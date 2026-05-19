<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Reminder;
use App\Models\ReminderHistory;
use App\Models\Activity;
use App\Models\UserNotificationSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class SendReminderNotifications extends Command
{
    protected $signature   = 'reminders:send';
    protected $description = 'Send reminder notifications';

    public function handle()
    {
        $now = Carbon::now();

        Log::info('====================');
        Log::info('Reminder Cron Started');
        Log::info('Current Time: ' . $now);

        $from = now()->copy()->subMinute()->format('H:i:s');
        $to   = now()->format('H:i:s');

        /*
        |----------------------------------------------------------------------
        | Fetch active reminders due right now
        |----------------------------------------------------------------------
        */
        $reminders = Reminder::with(['user', 'category', 'subcategory'])
            ->whereDate('reminder_date', now()->toDateString())
            ->whereTime('reminder_time', '>=', $from)
            ->whereTime('reminder_time', '<=', $to)
            ->where('status', 'Active')
            ->get();

        Log::info('Reminder Count: ' . $reminders->count());

        if ($reminders->isEmpty()) {
            Log::warning('No reminders found');
            return;
        }

        /*
        |----------------------------------------------------------------------
        | Firebase messaging instance (shared for all reminders)
        |----------------------------------------------------------------------
        */
        $messaging = null;
        try {
            $messaging = (new Factory)
                ->withServiceAccount(storage_path('app/firebase.json'))
                ->createMessaging();
        } catch (\Exception $e) {
            Log::error('Firebase init failed: ' . $e->getMessage());
        }

        foreach ($reminders as $reminder) {

            Log::info('Processing Reminder ID: ' . $reminder->id);

            /*
            |------------------------------------------------------------------
            | 1. Mark the matching ReminderHistory row as completed
            |------------------------------------------------------------------
            */
            $historyRow = ReminderHistory::where('reminder_id', $reminder->id)
                ->whereDate('reminder_date', $reminder->reminder_date)
                ->where('status', 'pending')
                ->first();

            if ($historyRow) {
                $historyRow->update([
                    'status'  => 'completed',
                    'sent_at' => now(),
                ]);
                Log::info('ReminderHistory ID ' . $historyRow->id . ' marked completed');
            } else {
                Log::warning('No pending history row found for Reminder ID: ' . $reminder->id);
            }

            /*
            |------------------------------------------------------------------
            | 2. Load user notification settings
            |------------------------------------------------------------------
            */
            $settings = UserNotificationSetting::where('user_id', $reminder->user_id)->first();

            /*
            |------------------------------------------------------------------
            | 3. Check quiet hours — if inside quiet window, skip all alerts
            |------------------------------------------------------------------
            */
            if ($settings && $settings->quit_hours && $settings->start_time && $settings->end_time) {

                $currentTime = now()->format('H:i');
                $startTime   = Carbon::parse($settings->start_time)->format('H:i');
                $endTime     = Carbon::parse($settings->end_time)->format('H:i');

                $inQuietWindow = false;

                if ($startTime <= $endTime) {
                    // Same-day window e.g. 09:00 – 17:00
                    $inQuietWindow = ($currentTime >= $startTime && $currentTime <= $endTime);
                } else {
                    // Overnight window e.g. 22:00 – 08:00
                    $inQuietWindow = ($currentTime >= $startTime || $currentTime <= $endTime);
                }

                if ($inQuietWindow) {
                    Log::info('Reminder ID ' . $reminder->id . ' skipped — quiet hours active (' . $startTime . ' – ' . $endTime . ')');

                    // Still handle recurring / end-date logic below
                    $this->handleRecurring($reminder);
                    continue;
                }
            }

            /*
            |------------------------------------------------------------------
            | 4. Send Email notification
            |------------------------------------------------------------------
            */
            if ($settings && $settings->email_notify && $reminder->user && $reminder->user->email) {
                try {
                    Mail::send(
                        'emails.reminder_alert',
                        [
                            'user'     => $reminder->user,
                            'reminder' => $reminder,
                            'category' => $reminder->category,
                        ],
                        function ($message) use ($reminder) {
                            $message->to($reminder->user->email);
                            $message->subject('Reminder Alert: ' . $reminder->title);
                        }
                    );
                    Log::info('Email sent for Reminder ID: ' . $reminder->id);
                } catch (\Exception $e) {
                    Log::error('Mail Error for Reminder ID ' . $reminder->id . ': ' . $e->getMessage());
                }
            }

            /*
            |------------------------------------------------------------------
            | 5. Send Push (FCM) notification
            |------------------------------------------------------------------
            */
            if (
                $settings &&
                $settings->push_notify &&
                $messaging &&
                $reminder->user &&
                $reminder->user->fcm_token
            ) {
                try {
                    $message = CloudMessage::fromArray([
                        'token' => $reminder->user->fcm_token,
                        'data'  => [
                            'title' => 'Winngoo Reminder Alert',
                            'body'  =>
                                $reminder->title .
                                ' | ' .
                                ($reminder->category->name    ?? 'No Category') .
                                ' → ' .
                                ($reminder->subcategory->name ?? 'No Subcategory'),
                        ],
                    ]);

                    $messaging->send($message);
                    Log::info('Push notification sent for Reminder ID: ' . $reminder->id);

                } catch (\Exception $e) {
                    Log::error('Firebase Error for Reminder ID ' . $reminder->id . ': ' . $e->getMessage());
                }
            }

            /*
            |------------------------------------------------------------------
            | 6. Log activity
            |------------------------------------------------------------------
            */
            Activity::create([
                'user_id'         => $reminder->user_id,
                'reminder_id'     => $reminder->id,
                'description'     => 'Reminder alert sent for "' . $reminder->title . '"',
                'is_auto_generate' => 1,
                'is_seen'         => 0,
            ]);

            /*
            |------------------------------------------------------------------
            | 7. Handle recurring / end-date logic
            |------------------------------------------------------------------
            */
            $this->handleRecurring($reminder);
        }

        Log::info('Reminder Cron Ended');
        Log::info('====================');
    }

    /*
    |--------------------------------------------------------------------------
    | Extracted recurring logic — shared by normal + quiet-hour paths
    |--------------------------------------------------------------------------
    */
    private function handleRecurring(Reminder $reminder): void
    {
        // One-time reminder (no frequency) — mark completed
        if (!$reminder->payment_frequency) {
            $reminder->reminder_status = 'completed';
            $reminder->save();
            Log::info('One-time reminder ID ' . $reminder->id . ' completed');
            return;
        }

        $monthsMap = [
            'monthly'     => 1,
            'quarterly'   => 3,
            'half-yearly' => 6,
            'annually'    => 12,
        ];

        $months = $monthsMap[strtolower($reminder->payment_frequency)] ?? 0;

        if ($months === 0) {
            Log::warning('Invalid payment_frequency for Reminder ID: ' . $reminder->id);
            return;
        }

        // Calculate next reminder date (preserve original day-of-month)
        $currentDate = Carbon::parse($reminder->reminder_date);
        $originalDay = $currentDate->day;
        $next        = $currentDate->copy()->addMonths($months);
        $nextDate    = $next->day(min($originalDay, $next->daysInMonth));

        Log::info('Next Reminder Date for ID ' . $reminder->id . ': ' . $nextDate->toDateString());

        // Check end date
        if (
            $reminder->end_reminder_date &&
            $reminder->end_reminder_date != '0000-00-00'
        ) {
            $endDate = Carbon::parse($reminder->end_reminder_date);

            if ($nextDate->gt($endDate)) {
                $reminder->reminder_status = 'completed';
                $reminder->save();
                Log::info('Reminder ID ' . $reminder->id . ' reached end date — completed');
                return;
            }
        }

        // Advance the reminder date
        $reminder->reminder_date = $nextDate->format('Y-m-d');
        $reminder->save();
        Log::info('Reminder ID ' . $reminder->id . ' advanced to ' . $nextDate->toDateString());
    }
}
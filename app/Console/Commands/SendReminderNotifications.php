<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Reminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class SendReminderNotifications extends Command
{
    protected $signature = 'reminders:send';

    protected $description = 'Send reminder notifications';

    public function handle()
{
    $now = Carbon::now();

    Log::info('====================');
    Log::info('Reminder Cron Started');
    Log::info('Current Time: '.$now);

    $from = now()->copy()->subMinute()->format('H:i:s');
    $to = now()->format('H:i:s');

    $reminders = Reminder::with(['user', 'category', 'subcategory'])
        ->whereDate('reminder_date', now()->toDateString())
        ->whereTime('reminder_time', '>=', $from)
        ->whereTime('reminder_time', '<=', $to)
        ->where('status', 'Active')
        ->get();

    Log::info('Reminder Count: '.$reminders->count());

    if ($reminders->isEmpty()) {

        Log::warning('No reminders found');

        return;
    }

    $messaging = (new Factory)
        ->withServiceAccount(storage_path('app/firebase.json'))
        ->createMessaging();

    foreach ($reminders as $reminder) {

        Log::info('Processing Reminder ID: '.$reminder->id);

        /*
        |--------------------------------------------------------------------------
        | SEND NOTIFICATION
        |--------------------------------------------------------------------------
        */

        if ($reminder->user && $reminder->user->fcm_token) {

            $message = CloudMessage::fromArray([
                'token' => $reminder->user->fcm_token,

                'data' => [
                    'title' => 'Winngoo Reminder Alert',

                    'body' =>
                        $reminder->title .
                        ' | ' .
                        ($reminder->category->name ?? 'No Category') .
                        ' → ' .
                        ($reminder->subcategory->name ?? 'No Subcategory'),
                ],
            ]);

            try {

                $messaging->send($message);

                Log::info('Notification Sent');

            } catch (\Exception $e) {

                Log::error('Firebase Error: '.$e->getMessage());
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RECURRING LOGIC
        |--------------------------------------------------------------------------
        */

        if (!$reminder->payment_frequency) {

    $reminder->reminder_status = 'completed';

    $reminder->save();

    Log::info('One-time reminder completed');

    continue;
}

        $months = 0;

        switch (strtolower($reminder->payment_frequency)) {

            case 'monthly':
                $months = 1;
                break;

            case 'quarterly':
                $months = 3;
                break;

            case 'half-yearly':
                $months = 6;
                break;

            case 'annually':
                $months = 12;
                break;
        }

        if ($months == 0) {

            Log::warning('Invalid payment frequency');

            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | CALCULATE NEXT REMINDER DATE
        |--------------------------------------------------------------------------
        */

        $currentReminderDate = Carbon::parse($reminder->reminder_date);

        $originalDay = $currentReminderDate->day;

        $next = $currentReminderDate->copy()->addMonths($months);

        $lastDay = $next->daysInMonth;

        $nextReminderDate = $next->day(min($originalDay, $lastDay));

        Log::info('Next Reminder Date: '.$nextReminderDate);

        /*
        |--------------------------------------------------------------------------
        | CHECK END DATE
        |--------------------------------------------------------------------------
        */

        if (
            $reminder->end_reminder_date &&
            $reminder->end_reminder_date != '0000-00-00'
        ) {

            $endDate = Carbon::parse($reminder->end_reminder_date);

            if ($nextReminderDate->gt($endDate)) {

                $reminder->reminder_status = 'completed';

                $reminder->save();

                Log::info('Reminder Completed');

                continue;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE NEXT REMINDER DATE
        |--------------------------------------------------------------------------
        */

        $reminder->reminder_date = $nextReminderDate->format('Y-m-d');

        $reminder->save();

        Log::info('Reminder Date Updated');
    }

    Log::info('Reminder Cron Ended');
    Log::info('====================');
}
}

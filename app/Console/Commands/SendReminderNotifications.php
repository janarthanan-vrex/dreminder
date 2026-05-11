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

        Log::info('From Time: '.$from);
        Log::info('To Time: '.$to);

        $reminders = Reminder::with('user')
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

            Log::info('Reminder ID: '.$reminder->id);
            Log::info('Reminder Title: '.$reminder->title);
            Log::info('Reminder Time: '.$reminder->reminder_time);

            if (!$reminder->user) {

                Log::error('User not found');

                continue;
            }

            Log::info('User ID: '.$reminder->user->id);

            if (!$reminder->user->fcm_token) {

                Log::error('FCM Token Missing');

                continue;
            }

            Log::info('FCM Token Found');

         $message = CloudMessage::fromArray([
    'token' => $reminder->user->fcm_token,

    'notification' => [
        'title' => 'Winngoo Dreminder Alert',

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

                Log::info('Notification Sent Successfully');

            } catch (\Exception $e) {

                Log::error('Firebase Error: '.$e->getMessage());
            }
        }

        Log::info('Reminder Cron Ended');
        Log::info('====================');
    }
}
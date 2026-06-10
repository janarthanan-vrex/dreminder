<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Models\AuditLog;

class SettingsController extends Controller
{

    public function adminSettings(Request $request)
    {
        $settings = Setting::getByGroup('email');
        $notificationSettings = Setting::getByGroup('notification');

        return view('admin.settings', compact('settings', 'notificationSettings'));
    }


    public function emailConfiguration()
    {
        $settings = Setting::where('group', 'email')
            ->pluck('value', 'key')
            ->toArray();
        // dd($settings);

        return view('admin.settings.email-configuration', compact('settings'));
    }


    public function notificationSettings()
    {
        $settings = Setting::where('group', 'notification')
            ->pluck('value', 'key')
            ->toArray();


        return view('admin.settings.notification-settings', compact('settings'));
    }

    public function saveEmailSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'smtp_server'     => 'required',
            'smtp_port'       => 'required',
            'smtp_username'   => 'required|email|same:from_email',
            'from_email'      => 'required|email',
            'encryption_type' => 'required',
            'from_name'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // ── Read old values BEFORE saving ─────────────────────────────────────
        $oldNotification = Setting::get('email_notifications', 'notification') ?? 0;
        $oldSmtpServer   = Setting::get('smtp_server',   'email') ?? '—';
        $oldSmtpPort     = Setting::get('smtp_port',     'email') ?? '—';
        $oldEncryption   = Setting::get('encryption_type', 'email') ?? '—';
        $oldFromName     = Setting::get('from_name',     'email') ?? '—';
        $oldFromEmail    = Setting::get('from_email',    'email') ?? '—';

        $newNotification = $request->boolean('email_notifications') ? 1 : 0;

        // Email notification toggle
        Setting::set('email_notifications', $newNotification, 'notification');

        // Email settings
        foreach ($request->except(['_token', 'email_notifications']) as $key => $value) {
            if ($key == 'smtp_password') {
                if (!empty($value)) {
                    Setting::set($key, encrypt($value), 'email');
                }
            } else {
                Setting::set($key, $value, 'email');
            }
        }

        // ── Build only changed fields ─────────────────────────────────────────
        $before = [
            'smtp_server'        => $oldSmtpServer,
            'smtp_port'          => (string) $oldSmtpPort,
            'encryption_type'    => strtoupper($oldEncryption),
            'from_name'          => $oldFromName,
            'from_email'         => $oldFromEmail,
            'email_notifications' => $oldNotification ? 'Enabled' : 'Disabled',
        ];

        $after = [
            'smtp_server'        => $request->smtp_server,
            'smtp_port'          => (string) $request->smtp_port,
            'encryption_type'    => strtoupper($request->encryption_type),
            'from_name'          => $request->from_name,
            'from_email'         => $request->from_email,
            'email_notifications' => $newNotification ? 'Enabled' : 'Disabled',
        ];

        $fieldLabels = [
            'smtp_server'         => 'SMTP Server',
            'smtp_port'           => 'SMTP Port',
            'encryption_type'     => 'Encryption',
            'from_name'           => 'From Name',
            'from_email'          => 'From Email',
            'email_notifications' => 'Email Notifications',
        ];

        $changedFields = [];
        foreach ($before as $key => $oldVal) {
            if ((string) $oldVal !== (string) $after[$key]) {
                $changedFields[] = [
                    'field' => $fieldLabels[$key],
                    'old'   => $oldVal,
                    'new'   => $after[$key],
                ];
            }
        }

        // Password logged separately — only if a new one was submitted
        if (!empty($request->smtp_password)) {
            $changedFields[] = [
                'field' => 'SMTP Password',
                'old'   => '••••••••',
                'new'   => '••••••••  (updated)',
            ];
        }

        if (!empty($changedFields)) {
            $summary = count($changedFields) === 1
                ? '1 Field Updated'
                : count($changedFields) . ' Fields Updated';

            AuditLog::record('Settings', 'Settings', $summary, $changedFields);
        }

        return response()->json([
            'success' => true,
            'message' => 'Email settings updated successfully!',
        ]);
    }

    public function sendTestMail()
    {

        // ✅ Check email notification setting
        $emailEnabled = Setting::where('key', 'email_notifications')
            ->where('group', 'notification')
            ->value('value');

        if (!$emailEnabled) {
            return response()->json([
                'success' => false,
                'message' => 'Email notifications are disabled.'
            ]);
        }
        $settings = Setting::getByGroup('email');

        if (empty($settings)) {
            return response()->json([
                'success' => false,
                'message' => 'No email settings found. Please save settings first.'
            ]);
        }

        // Decrypt password
        try {
            $password = decrypt($settings['smtp_password']);
        } catch (\Exception $e) {
            $password = $settings['smtp_password'];
        }

        // Dynamically set mail config from DB
        Config::set('mail.mailers.smtp.host',       $settings['smtp_server']);
        Config::set('mail.mailers.smtp.port',       $settings['smtp_port']);
        Config::set('mail.mailers.smtp.username',   $settings['smtp_username']);
        Config::set('mail.mailers.smtp.password',   $password);
        Config::set('mail.mailers.smtp.encryption', $settings['encryption_type']);
        Config::set('mail.from.address',            $settings['from_email']);
        Config::set('mail.from.name',               $settings['from_name']);

        // Static test recipient
        $staticTestEmail = 'jana2407@yopmail.com'; // 👈 change this to your email

        try {
            Mail::raw('This is a test email. Your SMTP configuration is working correctly!', function ($message) use ($staticTestEmail, $settings) {
                $message->to($staticTestEmail)
                    ->subject('Test Email - ' . ($settings['from_name'] ?? 'System'));
            });

            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully to ' . $staticTestEmail
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e->getMessage()
            ]);
        }
    }




    public function saveNotificationSettings(Request $request)
    {
        $value = $request->has('email_notifications') ? 1 : 0;

        Setting::set('email_notifications', $value, 'notification');

        return back()->with('success', 'Notification settings updated!');
    }
}

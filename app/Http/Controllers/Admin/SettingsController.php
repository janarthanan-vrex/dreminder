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
        'smtp_server' => 'required',
        'smtp_port' => 'required',
        'smtp_username' => 'required|email|same:from_email',
        'from_email' => 'required|email',
        'encryption_type' => 'required',
        'from_name' => 'required',
    ]);
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }
    // Email notification toggle
    Setting::set('email_notifications',$request->has('email_notifications') ? 1 : 0,'notification');
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
    return response()->json([
        'success' => true,
        'message' => 'Email settings updated successfully!'
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

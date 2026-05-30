<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;


class SystemController extends Controller
{
    public function feedbackPage(Request $request)
    {
        $feedbacks = Feedback::with('user')
            ->latest()
            ->get()
            ->map(function ($f) {

                return [

                    'id' => $f->id,

                    'user' => $f->user->first_name . ' ' . $f->user->last_name,

                    'email' => $f->user->email,

                    'phone' => $f->user->phone,

                    'subject' => $f->subject,

                    'category' => $f->priority,

                    'type' => strtolower($f->priority),

                    'status' => strtolower($f->feedback_status),

                    'msg' => $f->message,

                    'admin_reply' => $f->admin_reply,

                    'time' => $f->created_at->diffForHumans(),

                    'icon' =>
                    $f->priority == 'High'
                        ? 'ri-error-warning-line'
                        : ($f->priority == 'Medium'
                            ? 'ri-lightbulb-line'
                            : 'ri-message-2-line'),

                    'col' =>
                    $f->priority == 'High'
                        ? '#ef4444'
                        : ($f->priority == 'Medium'
                            ? '#94a3b8'
                            : '#10b981')

                ];
            });

        // Counts
        $totalFeedbacks = Feedback::count();

        $resolvedFeedbacks = Feedback::where('feedback_status', 'resolved')->count();

        $pendingFeedbacks = Feedback::where('feedback_status', 'pending')->count();

        return view('admin.feedback', compact(
            'feedbacks',
            'totalFeedbacks',
            'resolvedFeedbacks',
            'pendingFeedbacks'
        ));
    }

    public function sendVerificationMail(Request $request)
    {
        $user = User::findOrFail($request->id);
        $verifyUrl = route('verify.email', $user->email);
        Mail::send('emails.verify_mail', [
            'user' => $user,
            'verifyUrl' => $verifyUrl
        ], function ($m) use ($user) {
            $m->from(config('mail.from.address'), config('mail.from.name'));
            $m->to($user->email, $user->first_name . ' ' . $user->last_name)
                ->subject('Verify Your Email');
        });

        return response()->json([
            'status' => true,
            'message' => 'Verification mail sent successfully'
        ]);
    }

    public function replyFeedback(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:feedback,id',
            'reply' => 'required|string'

        ]);

        $feedback = Feedback::findOrFail($request->id);
        $feedback->update([
            'admin_reply' => $request->reply,
            'feedback_status' => 'resolved',
            'is_receive' => 1

        ]);

        Mail::send(
            'emails.feedback_reply',
            [
                'user' => $feedback->user,
                'feedback' => $feedback,
                'reply' => $request->reply,
                'subject' => $feedback->subject
            ],
            function ($mail) use ($feedback) {
                $mail->to($feedback->user->email)
                    ->subject($feedback->subject);
            }

        );

        return response()->json([
            'status' => true,
            'message' => 'Reply sent successfully'

        ]);
    }
}

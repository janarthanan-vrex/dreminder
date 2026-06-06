<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AuditLog;
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

    /* ── List page ── */
    public function index()
    {
       
        return view('admin.audit');
    }

    /* ── Paginated JSON for the JS table ── */
    public function fetch(Request $request)
    {
        $query = AuditLog::query()->latest();

        // Text search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('event',            'like', "%{$search}%")
                  ->orWhere('admin_name',     'like', "%{$search}%")
                  ->orWhere('module',         'like', "%{$search}%")
                  ->orWhere('ip_address',     'like', "%{$search}%")
                  ->orWhere('changes_summary','like', "%{$search}%");
            });
        }

        // Event filter
        if ($event = $request->input('event')) {
            $query->where('event', $event);
        }

        // User filter
        if ($user = $request->input('user')) {
            $query->where('admin_name', $user);
        }

        // Date filter
        if ($date = $request->input('date')) {
            match ($date) {
                'today' => $query->whereDate('created_at', today()),
                'week'  => $query->where('created_at', '>=', now()->subDays(7)),
                'month' => $query->where('created_at', '>=', now()->subMonth()),
                default => null,
            };
        }

        $perPage = (int) $request->input('per_page', 10);
        $logs    = $query->paginate($perPage);

        // Shape for the Blade JS
        $rows = $logs->map(function ($log) {
            return [
                'id'           => $log->id,
                'date'         => $log->created_at->format('Y-m-d'),
                'time'         => $log->created_at->format('h:i A'),
                'event'        => $log->event,
                'user'         => [
                    'name'     => $log->admin_name,
                    'initials' => $log->admin_initials,
                    'role'     => $log->admin_role,
                    'color'    => $log->admin_color,
                    'bg'       => $log->admin_bg,
                ],
                'module'       => $log->module,
                'moduleIcon'   => $log->module_icon,
                'changes'      => $log->changes_summary,
                'ip'           => $log->ip_address,
                'details'      => [
                    'fields'   => collect($log->changes_detail ?? [])->map(fn($f) => [
                        'field'  => $f['field']  ?? '',
                        'old'    => $f['old']    ?? null,
                        'newVal' => $f['new']    ?? null,
                    ])->all(),
                ],
            ];
        });

        return response()->json([
            'data'         => $rows,
            'current_page' => $logs->currentPage(),
            'last_page'    => $logs->lastPage(),
            'total'        => $logs->total(),
            'per_page'     => $logs->perPage(),
            'from'         => $logs->firstItem() ?? 0,
            'to'           => $logs->lastItem()  ?? 0,
        ]);
    }

    /* ── Clear all logs ── */
    public function clear()
    {
        AuditLog::truncate();

        return response()->json([
            'status'  => true,
            'message' => 'Audit log cleared',
        ]);
    }

    /* ── Get distinct users for the filter dropdown ── */
    public function users()
    {
        $users = AuditLog::select('admin_name')
            ->distinct()
            ->orderBy('admin_name')
            ->pluck('admin_name');

        return response()->json($users);
    }

    
    
}

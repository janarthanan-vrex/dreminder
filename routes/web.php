<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Exception\Messaging\NotFound;

Route::get('/test-notification', function () {

    if (!auth()->check()) {
        return "User not logged in ❌";
    }

    $user = auth()->user();

    // ✅ Token not ready yet
    if (!$user->fcm_token) {
        return "⚠️ FCM token not ready. Open dashboard and wait 2 seconds.";
    }

    $messaging = app('firebase.messaging');

    $message = CloudMessage::fromArray([
        'token' => $user->fcm_token,
        'data' => [
            'title' => 'Hello 🔔',
            'body' => 'This is notification for logged user',
        ],
    ]);

    try {
        $messaging->send($message);

        return response()->json([
            'status' => true,
            'message' => 'Notification sent successfully ✅',
            'token_used' => $user->fcm_token
        ]);

    } catch (NotFound $e) {

        // 🔥 Token invalid → reset
        $user->update(['fcm_token' => null]);

        return response()->json([
            'status' => false,
            'message' => '❌ Token expired. Refresh dashboard to regenerate.',
        ]);

    } catch (\Exception $e) {

        // 🔥 Any other Firebase error
        return response()->json([
            'status' => false,
            'message' => '🔥 Firebase error: ' . $e->getMessage()
        ]);
    }

});


Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route('user.dashboard'); // ✅ correct
    }

    return view('index');
});
Route::get('/index', function () {return view('index');});
Route::get('/about', function () {return view('about');});
Route::get('/category', function () {return view('category');});
Route::get('/faq', function () {return view('faq');});
Route::get('/blog', function () {return view('blog');});
Route::get('/blog-detail', function () {return view('blog-detail');});
Route::get('/contact', function () {return view('contact');});
Route::get('/pricing', function () {return view('pricing');});
Route::get('/privacy', function () {return view('privacy');});
Route::get('/terms', function () {return view('terms');});


Route::get('/login',[AuthController::class,'loginpage'])->name('loginpage');
Route::get('/register', [AuthController::class, 'registerpage'])->name('registerpage');
Route::post('/register', [AuthController::class, 'store'])->name('register.store');
Route::post('/coupon/apply',  [AuthController::class, 'applyCoupon'])->name('coupon.apply');
Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('check.email');
Route::get('/user/magic-login/{id}/{token}', [AuthController::class, 'magicLogin'])->name('user.magic.login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/save-token', [AuthController::class, 'saveToken'])->middleware('auth');

Route::get('/forgot-password',[AuthController::class,'forgotPasswordPage'])->name('forgotpassword.page');
Route::post('/store-forgot-password', [AuthController::class, 'storeForgotPassword'])->name('storeToken.forgotpassword');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/user/reset-password', [AuthController::class, 'resetPassword'])->name('user.reset-password');


Route::get('/reset-password', function () {return view('reset-password');});
Route::get('/test', function () {return view('test');});
Route::get('/invoice', function () {return view('emails.invoice_view');});


// Admin
Route::get('/admin-login', function () {return view('admin.admin-login');});
Route::get('/admin-forgot-password', function () {return view('admin.admin-forgot-password');});
Route::get('/admin-reset-password', function () {return view('admin.admin-reset-password');});


// Admin
Route::get('/admin-dashboard', function () { return view('admin.dashboard');});
Route::get('/admin-layout', function () { return view('admin.layout');});
Route::get('/admin-users', function () { return view('admin.users');});
Route::get('/admin-reminders', function () { return view('admin.reminders');});
Route::get('/admin-calendar', function () { return view('admin.calendar');});
Route::get('/admin-category', function () { return view('admin.category');});
Route::get('/admin-staff', function () { return view('admin.staff');});
Route::get('/admin-roles', function () { return view('admin.roles');});
Route::get('/admin-analytics', function () { return view('admin.analytics');});
Route::get('/admin-settings', function () { return view('admin.settings');});
Route::get('/admin-profile', function () { return view('admin.profile');});
Route::get('/admin-audit', function () { return view('admin.audit');});
Route::get('/admin-notifications', function () { return view('admin.notifications');});
Route::get('/admin-transactions', function () { return view('admin.transactions');});
Route::get('/admin-feedback', function () { return view('admin.feedback');});
Route::post('/logout', function () { Auth::logout(); return redirect('/admin-dashboard'); })->name('logout');

// Admin CMS
Route::get('/admin-pricing', function () { return view('admin.admin-pricing');});
Route::get('/admin-blog', function () {return view('admin.blog.admin-blog-list');})->name('admin.blog.index');
Route::get('/admin-blog-create', function () {return view('admin.blog.admin-blog-create');})->name('admin.blog.create');
Route::get('/admin-blog-edit', function () {return view('admin.blog.admin-blog-edit');})->name('admin.blog.edit');
Route::get('/admin-cms-home', function () { return view('admin.admin-cms-home');});
Route::get('/admin-cms-about', function () { return view('admin.admin-cms-about');});
Route::get('/admin-cms-faq', function () { return view('admin.admin-cms-faq');});
Route::get('/admin-cms-contact', function () { return view('admin.admin-cms-contact');});
Route::get('/admin-cms-terms', function () { return view('admin.admin-cms-terms');});
Route::get('/admin-cms-privacy', function () { return view('admin.admin-cms-privacy');});


// User

Route::get('/user-dashboard',[UserController::class,'userDashboard'])->name('user.dashboard');
Route::get('/user-profile', [UserController::class, 'userProfile'])->name('user.profile');
Route::post('/user/update-profile', [UserController::class, 'updateProfile'])->name('user.update.profile');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.change.password');
Route::get('/user-transaction',[UserController::class,'userTransaction'])->name('user.transactions');

Route::get('/user-analytics', function () {return view('user.analytics');});
Route::get('/user-calendar', function () {return view('user.calendar');});
Route::get('/user-reminder-history', function () {return view('user.reminder-history');});
Route::get('/user-category', function () {return view('user.category');});
Route::get('/user-create-reminder', function () {return view('user.create-reminder');});
Route::get('/user-feedback', function () {return view('user.feedback');});
Route::get('/user-help', function () {return view('user.help');});
Route::get('/user-membership', function () {return view('user.membership');});
Route::get('/user-notification', function () {return view('user.notification');});
Route::get('/user-reminders', function () {return view('user.reminders');});
Route::get('/user-templates', function () {return view('user.templates');});
Route::get('/user-shared-reminders', function () {return view('user.reminders');});
// Route::get('/user-transaction', function () {return view('user.transaction');});

Route::get('/layout', function () {return view('user.layout');});
Route::get('/loader', function () {return view('user.loader');});






Route::get('/transaction-invoice', function () {return view('user.invoice');});
Route::get('/transaction-invoice', function () {return view('admin.transaction-invoice');});
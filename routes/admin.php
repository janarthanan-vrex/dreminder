<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManagementController;
use App\Http\Controllers\Admin\SystemController;

Route::get('/admin-login', function () {

    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('admin.admin-login');
})->name('admin.loginpage');


// Route::get('/admin-login',[AdminController::class,'loginPage'])->name('admin.loginpage');

Route::post('/admin-login', [AdminController::class, 'adminLogin'])->name('admin.login');

Route::post('/admin-logout',[AdminController::class, 'adminLogout'])->name('admin.logout');



Route::get('/admin-fogotPage',[AdminController::class, 'adminforgotPage'])->name('admin.forgotPage');
Route::post('forgot-password',[AdminController::class, 'storeForgotPassword'])->name('admin.forgot-password.post');
Route::get('/admin-reset-password/{token}', [AdminController::class, 'showAdminResetForm'])->name('admin.password.reset');
Route::post('/admin/reset-password', [AdminController::class, 'adminResetPassword'])->name('admin.reset-password');
Route::get('/admin-dashboard',[AdminController::class,'adminDashboard'])->name('admin.dashboard');
Route::get('/admin-profile',[AdminController::class,'adminProfile'])->name('admin.profile');
Route::post('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
Route::post('/admin/change-password',[AdminController::class,'changePassword'])->name('admin.change.password');

Route::get('/admin-transactions',[ManagementController::class,'transactionPage'])->name('admin.transaction');


Route::get('/admin-users',[ManagementController::class,'userManagement'])->name('admin.usermanagement');
Route::delete('/admin/users/{id}',[ManagementController::class,'deleteUser'])->name('admin.users.delete');
Route::post('/admin/users/status',[ManagementController::class,'toggleUserStatus'])->name('admin.users.status');
Route::post('/admin/users/update',[ManagementController::class,'updateUser'])->name('admin.users.update');
Route::post('/admin/users/store',[ManagementController::class,'storeUser'])->name('admin.users.store');


Route::get('/admin-category',[ManagementController::class,'adminCategory'])->name('admin.category');
Route::post('/admin/category/store', [ManagementController::class, 'storeCategory'])->name('admin.category.store');
Route::post('/admin/subcategory/store',[ManagementController::class,'storeSubcategory'])->name('admin.subcategory.store');
Route::post('/admin/categories/delete',[ManagementController::class, 'deleteCategory'])->name('admin.categories.delete');
Route::post('/admin/subcategories/delete',[ManagementController::class, 'deleteSubcategory'])->name('admin.subcategories.delete');
Route::post('/admin/subcategories/update',[ManagementController::class, 'updateSubcategory'])->name('admin.subcategories.update');
Route::post('/admin/categories/update',[ManagementController::class, 'updateCategory'])->name('admin.categories.update');


Route::get('/admin-reminders',[ManagementController::class,'reminderPage',])->name('admin.reminderpage');
Route::get('/admin-calendar',[ManagementController::class,'calendarPage'])->name('admin.calendarpage');
Route::get('/admin/calendar/user-data',[ManagementController::class, 'getUserCalendar'])->name('admin.calendar.user.data');



Route::get('/admin-feedback',[SystemController::class,'feedbackPage'])->name('admin.feedback');
Route::post('/admin/send-verification-mail',[SystemController::class,'sendVerificationMail'])->name('admin.send.verification.mail');
Route::post('/admin/feedback/reply',[SystemController::class,'replyFeedback'])->name('admin.feedback.reply');
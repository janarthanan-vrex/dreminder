<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManagementController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\SettingsController;

Route::get('/admin-login', function () {

    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('admin.admin-login');
})->name('admin.loginpage');

Route::post('/admin-login', [AdminController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin-logout',[AdminController::class, 'adminLogout'])->name('admin.logout');
Route::get('/admin-fogotPage',[AdminController::class, 'adminforgotPage'])->name('admin.forgotPage');
Route::post('forgot-password',[AdminController::class, 'storeForgotPassword'])->name('admin.forgot-password.post');
Route::get('/admin-reset-password/{token}', [AdminController::class, 'showAdminResetForm'])->name('admin.password.reset');
Route::post('/admin/reset-password', [AdminController::class, 'adminResetPassword'])->name('admin.reset-password');

Route::middleware('admin.auth')->group(function () {
    
Route::get('/admin-dashboard',[AdminController::class,'adminDashboard'])->name('admin.dashboard');
Route::get('/admin-profile',[AdminController::class,'adminProfile'])->name('admin.profile');
Route::post('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
Route::post('/admin/change-password',[AdminController::class,'changePassword'])->name('admin.change.password');
Route::get('/admin/analytics/data',[AdminController::class, 'analyticsData']);



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
Route::get('/admin-notifications',[ManagementController::class,'notificationPage',])->name('admin.notifications');
Route::post('/admin/notification/read',[ManagementController::class, 'markNotificationRead']);
Route::post('/admin/notification/delete',[ManagementController::class, 'deleteNotification']);
Route::post('/admin/notification/read-all',[ManagementController::class,'markAllNotificationsRead']);
Route::post('/admin/notification/delete-all',[ManagementController::class,'deleteAllNotifications']);

Route::get('/admin-feedback',[SystemController::class,'feedbackPage'])->name('admin.feedback');
Route::post('/admin/send-verification-mail',[SystemController::class,'sendVerificationMail'])->name('admin.send.verification.mail');
Route::post('/admin/feedback/reply',[SystemController::class,'replyFeedback'])->name('admin.feedback.reply');
Route::get('/admin-blog',[SystemController::class, 'blogList'])->name('admin.blog.index');
Route::get('/admin-blog-create',[SystemController::class, 'createBlogs'])->name('admin.blog.create');
Route::post('blog',[SystemController::class, 'store'])->name('admin.blog.store');
Route::delete('/admin/blog/{post}',[SystemController::class, 'destroy'])->name('admin.blog.destroy');
Route::post('/admin/blog/{post}/toggle-status', [SystemController::class, 'toggleStatus'])->name('admin.blog.toggleStatus');
Route::get('blog/{post}/edit',  [SystemController::class, 'editBlogs'])->name('admin.blog.edit');
Route::post('blog/{post}/update', [SystemController::class, 'update'])->name('admin.blog.update');
Route::get('/admin-audit',          [SystemController::class, 'index'])->name('admin.audit.index');
Route::get('/admin/audit-log/fetch',    [SystemController::class, 'fetch'])->name('admin.audit.fetch');
Route::get('/admin/audit-log/users',    [SystemController::class, 'users'])->name('admin.audit.users');
Route::delete('/admin/audit-log/clear', [SystemController::class, 'clear'])->name('admin.audit.clear');


Route::get('/admin-pricing',[CmsController::class,'pricingPage'])->name('admin.pricing');
Route::post('/admin/save-plan',[CmsController::class,'savePlan'])->name('save.plan');
Route::delete('admin/delete-plan/{id}',[CmsController::class, 'deletePlan'])->name('delete.plan');
// Coupon routes
Route::get('admin/coupons',[CmsController::class, 'getCoupons'])->name('coupons.index');
Route::post('admin/coupons',[CmsController::class, 'createCoupon'])->name('coupons.store');
Route::put('admin/coupons/{id}',[CmsController::class, 'updateCoupon'])->name('coupons.update');
Route::delete('admin/coupons/{id}',[CmsController::class, 'deleteCoupon'])->name('coupons.destroy');
Route::get('/admin-cms-privacy',[CmsController::class, 'privacyPolicy'])->name('admin.cms.privacy');
Route::post('/admin/privacy-policy/save', [CmsController::class, 'savePrivacyPolicy'])->name('privacy-policy.save');
Route::get('/admin-cms-terms',[CmsController::class, 'termsCondition'])->name('admin.cms.terms');
Route::post('/admin/terms-condition/save', [CmsController::class, 'saveTermsCondition'])->name('terms-condition.save');
Route::get('/admin-cms-faq',[CmsController::class,'faqPage'])->name('admin.faq');

Route::post  ('/admin/cms/faqs',[CmsController::class, 'storeFaq']);
Route::put   ('/admin/cms/faqs/{faq}',[CmsController::class, 'updateFaq']);
Route::delete('/admin/cms/faqs/{faq}',[CmsController::class, 'destroyFaq']);
Route::post  ('/admin/cms/faqs/reorder',[CmsController::class, 'reorderFaqs']);
Route::post  ('/admin/cms/categories',[CmsController::class, 'storeCategory']);
Route::put   ('/admin/cms/categories/{faqCategory}',[CmsController::class, 'updateCategory']);
Route::delete('/admin/cms/categories/{faqCategory}',[CmsController::class, 'destroyCategory']);

Route::get('/admin-roles',[TeamController::class,'rolesPage'])->name('admin.roles');
Route::post('/admin/roles/store',[TeamController::class,'store'])->name('admin.roles.store');
Route::put('/admin/roles/{id}',[TeamController::class, 'update']) ->name('update');
Route::delete('/admin/roles/{id}',[TeamController::class, 'destroy'])->name('destroy');
Route::get('/admin-staff',[TeamController::class,'staffManagemant'])->name('admin.staff');
Route::post('/admin/staff/store',[TeamController::class, 'storeStaff'])->name('admin.staff.store');
Route::put('/admin/staff/{id}',[TeamController::class, 'updateStaff'])->name('admin.staff.update');
Route::delete('/admin/staff/{id}',[TeamController::class, 'destroyStaff'])->name('admin.staff.destroy');

Route::post('/settings/email/test',[SettingsController::class, 'sendTestMail'])->name('settings.email.test');
Route::post('/admin/settings/email', [SettingsController::class, 'saveEmailSettings'])->name('settings.email.save');
Route::get('/admin-settings',[SettingsController::class,'adminSettings'])->name('admin.settings');

});

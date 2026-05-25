<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManagementController;

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
Route::get('/reset-password/{token}', [AdminController::class, 'showAdminResetForm'])->name('admin.password.reset');
Route::post('/admin/reset-password', [AdminController::class, 'adminResetPassword'])->name('admin.reset-password');
Route::get('/admin-dashboard',[AdminController::class,'adminDashboard'])->name('admin.dashboard');

Route::get('/admin-transactions',[ManagementController::class,'transactionPage'])->name('admin.transaction');


Route::get('/admin-category',[ManagementController::class,'adminCategory'])->name('admin.category');
Route::post('/admin/category/store', [ManagementController::class, 'storeCategory'])->name('admin.category.store');
Route::post('/admin/subcategory/store',[ManagementController::class,'storeSubcategory'])->name('admin.subcategory.store');
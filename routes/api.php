<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ManagementController;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Exception\Messaging\InvalidMessage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// =======================
// PUBLIC ROUTES
// =======================

Route::post('/login', [AuthController::class, 'login']);
Route::post('/create-payment-intent', [AuthController::class, 'createPaymentIntent']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/verify-reset-token', [AuthController::class, 'verifyResetToken']);
Route::get('get-category', [AuthController::class, 'getcategory']);
Route::get('get-plans', [AuthController::class, 'getPlans']);
Route::get('get-coupons', [AuthController::class, 'getCoupons']);
Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
Route::post('/apply-coupon', [AuthController::class, 'applyCoupon']);

Route::post('/check-email', [AuthController::class, 'checkEmail']);
Route::post('/check-phone', [AuthController::class, 'checkPhone']);



// =======================
// PROTECTED ROUTES (LOGIN REQUIRED)
// =======================

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::get('/user-transactions', [AuthController::class, 'userTransaction']);
    Route::get('/user-notifications', [AuthController::class, 'userNotifications']);
    Route::post('/feedback', [AuthController::class, 'storeFeedback']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);



    // Test push to mobile
    Route::get('/test-notification', function (Request $request) {
        $user = $request->user();

        // Optional: pass ?token=xxx to test a specific device token directly
        $token = $request->query('token', $user->fcm_token);

        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => '⚠️ No FCM token. Call /api/save-fcm-token first.',
            ], 422);
        }

        $messaging = app('firebase.messaging');

        $message = CloudMessage::fromArray([
            'token' => $token,
            'notification' => [
                'title' => 'Hello 🔔',
                'body'  => 'This is a test notification',
            ],
            'data' => [
                'type' => 'test',
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK', // only if Flutter
            ],
        ]);

        try {
            $messaging->send($message);

            return response()->json([
                'status' => true,
                'message' => 'Notification sent successfully ✅',
            ]);
        } catch (NotFound $e) {
            // Token is invalid/unregistered, so clear it
            $user->update(['fcm_token' => null]);

            return response()->json([
                'status' => false,
                'message' => '❌ Token expired/invalid. Re-register from the app.',
            ], 410);
        } catch (InvalidMessage $e) {
            return response()->json(['status' => false, 'message' => 'Invalid token/message: ' . $e->getMessage()], 422);
        } catch (\Throwable $e) {
            return response()->json(['status' => false, 'message' => '🔥 Firebase error: ' . $e->getMessage()], 500);
        }
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user-reminders', [ManagementController::class, 'userReminders']);
    Route::delete('/delete/reminder/{id}', [ManagementController::class, 'deleteReminder']);
    Route::put('/update/reminder/{id}', [ManagementController::class, 'updateReminder']);
    Route::post('/store/reminder', [ManagementController::class, 'storeReminder']);
    Route::get('/calendar', [ManagementController::class, 'calendarView']);
    Route::post('/store/subcategory', [ManagementController::class, 'storeSubCategory']);
    Route::put('/update/subcategory/{id}', [ManagementController::class, 'updateSubcategory']);
    Route::delete('/delete/subcategory/{id}', [ManagementController::class, 'deleteSubCategory']);
    Route::get('get-subcategory', [AuthController::class, 'getSubCategory']);
    Route::get('/categories', [ManagementController::class, 'userCategory']);
    Route::post('/notification-settings', [ManagementController::class, 'updateOrCreate']);
    Route::post('/notifications/{id}/read', [ManagementController::class, 'markNotificationRead']);
    Route::post('/notifications/read-all', [ManagementController::class, 'markAllRead']);
    Route::delete('/notifications/delete-all', [ManagementController::class, 'clearAllNotifications']);
    Route::delete('/delete/notification/{id}', [ManagementController::class, 'deleteNotification']);
});

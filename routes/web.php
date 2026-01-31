<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

/*admin aouts*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // الحجوزات
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{booking}/edit', [AdminController::class, 'editBooking'])->name('edit_booking');
    Route::put('/bookings/{booking}', [AdminController::class, 'updateBooking'])->name('update_booking');
    Route::delete('/bookings/{booking}', [AdminController::class, 'deleteBooking'])->name('delete_booking');

    // المستخدمون
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('edit_user');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('update_user');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('delete_user');

    // المضيفون
    Route::get('/hosts', [AdminController::class, 'hosts'])->name('hosts');

    // الأنشطة
    Route::get('/activities', [AdminController::class, 'activities'])->name('activities');
    Route::get('/activities/{activity}/edit', [AdminController::class, 'editActivity'])->name('edit_activity');
    Route::put('/activities/{activity}', [AdminController::class, 'updateActivity'])->name('update_activity');
    Route::delete('/activities/{activity}', [AdminController::class, 'deleteActivity'])->name('delete_activity');
    Route::get('/create_activity', [AdminController::class, 'create_activity'])->name('create_activity');
    Route::post('/create_activity', [AdminController::class, 'storeActivity'])->name('store_activity');

    // التقييمات
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
    Route::get('/reviews/{review}/edit', [AdminController::class, 'editReview'])->name('edit_review');
    Route::put('/reviews/{review}', [AdminController::class, 'updateReview'])->name('update_review');
    Route::delete('/reviews/{review}', [AdminController::class, 'deleteReview'])->name('delete_review');

    // الأرباح
    Route::get('/earnings', [AdminController::class, 'earnings'])->name('earnings');

    // الملف الشخصي
    Route::get('/admin_profile', [AdminController::class, 'admin_profile'])->name('admin_profile');
    Route::put('/admin_profile', [AdminController::class, 'updateProfile'])->name('update_profile');
});

   /*owner routs*/

Route::middleware(['auth', 'role'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');

    // الحجوزات
    Route::get('/bookings', [OwnerController::class, 'bookings'])->name('bookings');
    Route::delete('/bookings/{booking}', [OwnerController::class, 'deleteBooking'])->name('delete_booking');

   
 // الأنشطة
 Route::get('/activities', [OwnerController::class, 'activities'])->name('activities');
    Route::get('/add_activity', [OwnerController::class, 'add_activity'])->name('add_activity');
    Route::post('/add_activity', [OwnerController::class, 'storeActivity'])->name('store_activity');
    Route::get('/activities/{activity}/edit', [OwnerController::class, 'editActivity'])->name('edit_activity');
    Route::put('/activities/{activity}', [OwnerController::class, 'updateActivity'])->name('update_activity');
    Route::delete('/activities/{activity}', [OwnerController::class, 'deleteActivity'])->name('delete_activity');

    // الإيرادات
    Route::get('/earnings', [OwnerController::class, 'earnings'])->name('earnings');

    // التقييمات
    Route::get('/reviews', [OwnerController::class, 'reviews'])->name('reviews');
    Route::delete('/reviews/{review}', [OwnerController::class, 'deleteReview'])->name('delete_review');
});
    /*user routs*/

Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');
Route::get('/register', [UserController::class, 'register'])->name('user.register');
Route::post('/register', [UserController::class, 'register'])->name('user.register.store');
// عرض صفحة الملف الشخصي
Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');

// تحديث بيانات الحساب
Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.update_profile');

// تحديث كلمة المرور
Route::put('/profile/change-password', [UserController::class, 'changePassword'])->name('user.change_password');
Route::get('/activities', [UserController::class, 'activities'])->name('user.activities');
Route::get('/activity_details/{id}', [UserController::class, 'activity_details'])->name('user.activity_details');
Route::get('/bookings', [UserController::class, 'bookings'])->name('user.bookings');
Route::get('/activities/{activity}/book', [UserController::class, 'showBookingForm'])
    ->name('booking.create')
    ->middleware('auth');

Route::post('/activities/{activity}/book', [UserController::class, 'createBooking'])
    ->name('booking.store')
    ->middleware('auth');


Route::delete('/bookings/{booking}/cancel', [UserController::class, 'cancelBooking'])->name('booking.cancel');
// تسجيل الخروج
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('home')->with('success', 'You have successfully logged out.');
})->name('logout');
// routes/web.php
Route::post('/booking/review/{booking}', [UserController::class, 'submitReview'])->name('booking.review');







// ... مسارات أخرى موجودة في الملف

// ✅ البايمنت راوتات (مرتبة ومرتبطة بالـ auth)
Route::middleware('auth')->group(function () {
    Route::get('/booking/payment/{booking}', [PaymentController::class, 'create'])
        ->name('booking_payment.create');
    
    Route::post('/booking/payment/{booking}', [PaymentController::class, 'store'])
        ->name('booking_payment.store');
    
   // routes/web.php

Route::get('/payment/confirm', [PaymentController::class, 'confirm'])
    ->name('booking_payment.confirm');
});

// ✅ مسارات البايمنت الأخرى (مرتبة)
Route::middleware('auth')->group(function () {
    Route::get('/activities/{activity}/payment', [UserController::class, 'showPaymentForm'])
        ->name('booking.payment.form');
    
    Route::post('/activities/{activity}/payment', [UserController::class, 'processPaymentForm'])
        ->name('booking.payment.process');
    
    Route::post('/activities/{activity}/booking-session', [UserController::class, 'storeBookingSession'])
        ->name('booking.session.store');
    
    Route::get('/activities/{activity}/payment-summary', [UserController::class, 'showPaymentSummary'])
        ->name('booking.payment.summary');
    
    Route::post('/activities/{activity}/process-payment', [UserController::class, 'processPayment'])
        ->name('booking.payment.process');
});
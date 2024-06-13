<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('payments/notification', [\App\Http\Controllers\PaymentController::class, 'notification'])->name('payment.notification');
Route::get('payments/completed', [\App\Http\Controllers\PaymentController::class, 'completed'])->name('payment.completed');
Route::get('payments/failed', [\App\Http\Controllers\PaymentController::class, 'failed'])->name('payment.failed');
Route::get('payments/unfinish', [\App\Http\Controllers\PaymentController::class, 'unfinish'])->name('payment.unfinish');

Route::get('text', function () {
    return view('frontend.payments.success');
});

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('homepage');

Route::get('search', [\App\Http\Controllers\ShopController::class, 'search'])->name('search');
Route::get('shop/{slug?}', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('shop/tag/{slug}', [\App\Http\Controllers\ShopController::class, 'tag'])->name('shop.tag');
Route::get('product/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.show');

// Rute untuk tampilan layanan yang dapat diakses tanpa login
Route::get('/service', [\App\Http\Controllers\ServiceController::class, 'index'])->name('service.index');
Route::get('/service/{id}', [\App\Http\Controllers\ServiceController::class, 'show'])->name('service.show');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('favorite', \App\Http\Controllers\FavoriteController::class)->only(['index', 'store', 'destroy']);
    Route::resource('cart', \App\Http\Controllers\CartController::class)->only(['index', 'store', 'update', 'destroy']);

    // Rute untuk pemesanan layanan yang memerlukan login
    Route::post('/service', [\App\Http\Controllers\ServiceController::class, 'store'])->name('service.store');
    Route::put('/service/{id}', [\App\Http\Controllers\ServiceController::class, 'update'])->name('service.update');
    Route::delete('/service/{id}', [\App\Http\Controllers\ServiceController::class, 'destroy'])->name('service.destroy');

    Route::resource('/booking', \App\Http\Controllers\BookingController::class);
    Route::get('/bookings/{bookingId}', [\App\Http\Controllers\BookingController::class, 'showBooking'])->name('bookings.show');

    Route::post('/midtrans-callback', [\App\Http\Controllers\BookingController::class, 'midtrans_callback']);
    Route::get('/payment-success/{bookingId}/{scheduleId}', [\App\Http\Controllers\BookingController::class, 'payment_success'])->name('payment.success');
    Route::get('/booking/{bookingId}/print', [\App\Http\Controllers\BookingController::class, 'printBill'])->name('booking.print');

    Route::get('profile', [\App\Http\Controllers\Auth\ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [\App\Http\Controllers\Auth\ProfileController::class, 'update'])->name('profile.update');

    Route::get('orders/checkout', [\App\Http\Controllers\OrderController::class, 'process'])->name('checkout.process');
    Route::get('orders/cities', [\App\Http\Controllers\OrderController::class, 'cities']);
    Route::post('orders/shipping-cost', [\App\Http\Controllers\OrderController::class, 'shippingCost']);
    Route::post('orders/set-shipping', [\App\Http\Controllers\OrderController::class, 'setShipping']);
    Route::post('orders/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
    Route::get('orders/received/{orderId}', [\App\Http\Controllers\OrderController::class, 'received'])->name('checkout.received');
    Route::get('orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{orderId}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::get('/order-success/{orderId}', [\App\Http\Controllers\OrderController::class, 'order_success'])->name('order.success');

    Route::group(['middleware' => 'isAdmin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('tags', \App\Http\Controllers\Admin\TagController::class);
        Route::post('/products/remove-image', [\App\Http\Controllers\Admin\ProductController::class, 'removeImage'])->name('products.removeImage');
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        
        Route::resource('schedule', \App\Http\Controllers\Admin\ScheduleController::class);
        Route::resource('category', \App\Http\Controllers\Admin\ServiceCategoryController::class);
        Route::resource('service', \App\Http\Controllers\Admin\ServiceController::class);
        Route::resource('obtained', \App\Http\Controllers\Admin\ObtainedController::class);

        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'destroy']);
        Route::post('orders/{order}/mark-as-paid', [\App\Http\Controllers\Admin\OrderController::class, 'markAsPaid'])->name('orders.markAsPaid');
        Route::post('orders/{order}/save-payment', [\App\Http\Controllers\Admin\OrderController::class, 'savePayment'])->name('orders.savePayment');
        Route::get('orders/{orderId}/cancel', [\App\Http\Controllers\Admin\OrderController::class, 'cancel'])->name('orders.cancel');
        Route::put('orders/cancel/{orderId}', [\App\Http\Controllers\Admin\OrderController::class, 'cancelUpdate'])->name('orders.cancelUpdate');
        Route::post('orders/complete/{orderId}', [\App\Http\Controllers\Admin\OrderController::class, 'complete'])->name('orders.complete');
        Route::resource('/booking', \App\Http\Controllers\Admin\BookingController::class);
        Route::get('booking/{id}/view', [\App\Http\Controllers\Admin\BookingController::class, 'view'])->name('booking.view');
        Route::delete('booking/{id}', [\App\Http\Controllers\Admin\BookingController::class, 'destroy'])->name('booking.destroy');
        
        Route::get('reports/revenue', [\App\Http\Controllers\Admin\ReportController::class, 'revenue'])->name('reports.revenue');
        Route::post('reports/print', [\App\Http\Controllers\Admin\ReportController::class, 'print'])->name('reports.print');
        Route::post('reports/download', [\App\Http\Controllers\Admin\ReportController::class, 'download'])->name('reports.download');
        Route::get('/reports/total-revenue', [\App\Http\Controllers\Admin\ReportController::class, 'totalRevenue'])->name('reports.total-revenue');
        Route::post('reports/view',  [\App\Http\Controllers\Admin\ReportController::class, 'view'])->name('reports.view');
    });
});

Auth::routes();
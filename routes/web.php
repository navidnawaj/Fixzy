<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard',  function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [ProfileController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// Route::get('/services', [ServiceController::class, 'index'])->name('service.services');
// Route::get('/services/create', [ServiceController::class, 'create'])->name('service.create');
// Route::get('/services/{service}', [ServiceController::class, 'view_service'])->name('service.view');
// Route::post('/services', [ServiceController::class, 'store'])->name('service.store');

Route::get('/services', [ServiceController::class, 'index'])->name('service.services');
Route::get('/services/create', [ServiceController::class, 'create'])->name('service.create'); // move this up
Route::post('/add_services', [ServiceController::class, 'store'])->name('service.store');
Route::get('/services/{service}', [ServiceController::class, 'view_service'])->name('service.view');
Route::get('/my_services', [ServiceController::class, 'view_services'])->name('service.my_services');
Route::delete('/services/{service}/delete', [ServiceController::class, 'destroy'])->name('service.delete');




Route::post('/order/{serviceId}', [OrderController::class, 'store'])->middleware('auth')->name('order.store');
Route::get('/my-orders', [OrderController::class, 'customerOrders'])->middleware('auth')->name('order.customer');
Route::get('/provider/orders', [OrderController::class, 'providerOrders'])->middleware('auth')->name('order.provider');
Route::get('/provider/orders', [OrderController::class, 'providerOrders'])
    ->middleware('auth') // Only authenticated users can view this page
    ->name('order.providers');
Route::put('/orders/{order}/mark-completed', [OrderController::class, 'markCompleted'])->name('orders.markCompleted');
Route::get('/analytics', [OrderController::class, 'providerAnalytics'])->name('provider.analytics');


Route::get('/customer/orders', [OrderController::class, 'customerOrders'])
    ->middleware('auth') // Only authenticated users can view this page
    ->name('customer.orders');
Route::get('/orders/{order}', [OrderController::class, 'view_order'])->name('order.view');
Route::post('/feedbackposted/{id}', [OrderController::class, 'store_feedback'])->name('feedback.store');
Route::get('/admindashboard', [OrderController::class, 'platformAnalytics'])->name('admin.analytics');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::match(['GET', 'POST'], '/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat');

//API

Route::get('service', [ServiceController::class, 'serviceapi'])->name('api.services');

require __DIR__.'/auth.php';

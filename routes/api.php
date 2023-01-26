<?php

use Illuminate\Support\Facades\Route;

// public routes
Route::name('api.')->group(function () {
    Route::post('register', \App\Http\Controllers\Api\Auth\RegisterController::class)
        ->name('register');
    Route::post('login', \App\Http\Controllers\Api\Auth\LoginController::class)
        ->name('login');
    Route::post('password/reset', [\App\Http\Controllers\Api\Auth\PasswordController::class, 'resetPassword'])
        ->name('password.reset');

    // list properties
    Route::get('pub/properties', [\App\Http\Controllers\Api\PublicController::class, 'properties'])
        ->name('pub.properties.index');
    Route::get('pub/properties/{property}', [\App\Http\Controllers\Api\PublicController::class, 'propertyView'])
        ->name('pub.properties.show');
});

Route::resource('payments', \App\Http\Controllers\Api\PaymentController::class)
    ->only(['store']);

// authenticated routes
Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::post('verify', [\App\Http\Controllers\Api\Auth\AccountController::class, 'verify'])
        ->name('verify');

    Route::post('logout', [\App\Http\Controllers\Api\Auth\AccountController::class, 'logout'])
        ->name('logout');
});

// authenticated and verified routes: all
Route::middleware(['auth:sanctum', 'verified', 'active'])->name('api.')->group(function () {
    Route::get('profile', [\App\Http\Controllers\Api\Auth\AccountController::class, 'profile'])
        ->name('profile');

    Route::post('password/update', [\App\Http\Controllers\Api\Auth\PasswordController::class, 'changePassword'])
        ->name('password.update');

    Route::resource('payments', \App\Http\Controllers\Api\PaymentController::class)
        ->except(['store']);
});


// authenticated and verified routes: landlord
Route::middleware(['auth:sanctum', 'role:landlord,admin', 'verified', 'active'])->name('api.')->group(function () {
    Route::apiResource('properties', \App\Http\Controllers\Api\PropertyController::class);
    Route::put('properties/restore/{property}', [\App\Http\Controllers\Api\PropertyController::class, 'restore'])
        ->name('property.restore');
    Route::post('property/{property}/ci_update', [\App\Http\Controllers\Api\PropertyController::class, 'changeCoverImage'])
        ->name('property.ci_update');
    Route::post('property/{property}/image_upload', [\App\Http\Controllers\Api\PropertyController::class, 'uploadImage'])
        ->name('property.image_upload');

    // bookings
    Route::get('bookings', [\App\Http\Controllers\Api\MyBookingController::class, 'index'])
        ->name('bookings.index');
    Route::put('bookings/{booking}/confirm', [\App\Http\Controllers\Api\MyBookingController::class, 'confirm'])
        ->name('bookings.confirm');
});

// authenticated and verified routes: client
Route::middleware(['auth:sanctum', 'role:client', 'verified', 'active'])->prefix('client')->name('api.client.')->group(function () {
    Route::apiResource('bookings', \App\Http\Controllers\Api\BookingController::class)
        ->except(['store']);
    Route::post('property/{property}/bookings', [\App\Http\Controllers\Api\BookingController::class, 'store'])
        ->name('booking.store');
    Route::put('bookings/restore/{booking}', [\App\Http\Controllers\Api\BookingController::class, 'restore'])
        ->name('bookings.restore');
});

// authenticated and verified routes: admin
Route::middleware(['auth:sanctum', 'role:admin', 'verified', 'active'])->prefix('admin')->name('api.admin.')->group(function () {
    Route::get('landlords', [\App\Http\Controllers\Api\AdminPropertyController::class, 'landlords'])
        ->name('landlords');
    Route::get('clients', [\App\Http\Controllers\Api\AdminPropertyController::class, 'clients'])
        ->name('clients');
    Route::put('user/{user}/revoke_roles', [\App\Http\Controllers\Api\UserController::class, 'revokeRoles'])
        ->name('roles.revoke');
    Route::put('user/{user}/update_roles', [\App\Http\Controllers\Api\UserController::class, 'updateRoles'])
        ->name('roles.update');
    Route::put('property/{property}/approve', [\App\Http\Controllers\Api\AdminPropertyController::class, 'approve'])
        ->name('property.approve');
    Route::put('property/{property}/transfer', [\App\Http\Controllers\Api\AdminPropertyController::class, 'transfer'])
        ->name('property.transfer');
});

<?php

declare(strict_types=1);

Route::middleware('guest')->group(function (): void {
    Route::get('login', fn () => 'Hello World')
        ->name('login');

    Route::get('forgot-password', fn () => 'Hello World')
        ->name('password.request');

});

Route::middleware('auth')->group(function (): void {
    Route::get('dashboard', fn () => 'Dashboard')
        ->name('dashboard');
});

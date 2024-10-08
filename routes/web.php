<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// route return hello world arrow function
Route::get('/', fn () => 'Hello World')->name('home');


// Route::name('user.')->group(function (): void {
//     require __DIR__.'/user.php';
// });

Route::name('admin.')->prefix('adminino')->group(function (): void {
    require __DIR__.'/admin.php';
});

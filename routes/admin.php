<?php

declare(strict_types=1);

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Admin\Admins\EditAdmin;
use App\Livewire\Admin\Admins\ShowAdmins;
use App\Livewire\Admin\Admins\CreateAdmin;
use App\Livewire\Admin\Auth\ResetPassword;
use App\Livewire\Admin\Auth\ForgotPassword;
use App\Livewire\Admin\Profile\UpdateProfile;
use App\Livewire\Admin\Settings\ManageSettings;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Livewire\Admin\Admins\ManageAdminRolesPermissions;
use App\Livewire\Admin\AdminRolePermission\EditRolePermisison;
use App\Livewire\Admin\AdminRolePermission\ShowRolePermissions;
use App\Livewire\Admin\AdminRolePermission\CreateRolePermisison;

// Redirect to admin.login by default
Route::get('/', fn () => redirect()->route('admin.login'))->name('adminino');

// Middleware for guests only (not logged in)
Route::middleware('guest:admin')->group(function (): void {
    // Admin login route
    Route::get('login', Login::class)
        ->name('login');

    // Admin forgot password route
    Route::get('forgot-password', ForgotPassword::class)
        ->name('password.request');

    Route::get('reset-password/{id}/{token}', ResetPassword::class)
        ->middleware(['signed', 'throttle:10,1'])
        ->name('password.reset');
});

Route::get('email/verify/{admin}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:10,1'])
    ->name('verification.verify');

// Middleware for authenticated admin users only
Route::middleware('auth:admin')->group(function (): void {

    Route::get('profile', UpdateProfile::class)->name('profile');

    Route::middleware('verified:admin.profile')->group(function () {

        // Admin dashboard route
        Route::get('dashboard', Dashboard::class)->name('dashboard');

        // Admins Routes
        Route::get('admins', ShowAdmins::class)->can('view:admin')->name('admins.index');
        Route::get('admins/create', CreateAdmin::class)->can('create:admin')->name('admins.create');
        Route::get('admins/{admin}/edit', EditAdmin::class)->can('update:admin')->name('admins.edit');
        Route::get('admins/{admin}/permissions', ManageAdminRolesPermissions::class)->can('update:admin-role-permission')->name('admins.permissions');

        // Admins Routes
        Route::get('admins/roles', ShowRolePermissions::class)->can('view:admin-role-permission')->name('admins.roles.index');
        Route::get('admins/roles/create', CreateRolePermisison::class)->can('create:admin-role-permission')->name('admins.roles.create');
        Route::get('admins/roles/{role}/edit', EditRolePermisison::class)->can('update:admin-role-permission')->name('admins.roles.edit');

        Route::get('settings', ManageSettings::class)->name('settings.index');

    });
});

<?php

declare(strict_types=1);

namespace App\Providers;

use Override;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        $settings = Cache::rememberForever('site_settings', fn () => Setting::all()->pluck('value', 'key')->toArray());

        config(['setting' => $settings]);

    }
}

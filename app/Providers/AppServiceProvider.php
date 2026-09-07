<?php

namespace App\Providers;

use App\Settings\SiteSettings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        View::composer('*', function ($view) {
            $view->with('settings', app(SiteSettings::class));
        });
    }
}

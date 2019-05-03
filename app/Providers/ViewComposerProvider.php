<?php

namespace App\Providers;

use App\Models\UsageStatistics;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //

        View::composer('welcome', function ($view) {
            $stats = UsageStatistics::firstOrCreate([]);
            $view->withStats($stats);

        });

        View::composer('welcome_writer', function ($view) {
            $stats = UsageStatistics::firstOrCreate([]);
            $view->withStats($stats);
        });
    }
}

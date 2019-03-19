<?php

namespace App\Providers;

use App\Plugins\AfricasTalking;
use Illuminate\Support\ServiceProvider;

class FacadeProvider extends ServiceProvider
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
        $this->app->bind('africa_talk',AfricasTalking::class);

    }
}

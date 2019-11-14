<?php

namespace App\Providers;

use Jenssegers\Agent\Agent;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AgentServiceProvider extends ServiceProvider
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
        $agent = new Agent();
        View::share('agent', $agent);
    }
}

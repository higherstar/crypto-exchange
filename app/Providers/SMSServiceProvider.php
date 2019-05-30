<?php

namespace App\Providers;

use App\Interfaces\SMS\NexmoSMS;
use App\Interfaces\SMS\SMSProviderInterface;
use Illuminate\Support\ServiceProvider;

class SMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SMSProviderInterface::class, function ($app) {
            return new NexmoSMS();
        });
    }
}

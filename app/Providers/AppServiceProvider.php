<?php

namespace App\Providers;

use App\API\YallaBit\Bitstamp;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('kuwaiti_mobile_number', function ($attribute, $value, $parameters, $validator) {
            $pattern =  '/^[965][0-9]{7}$/';
            return preg_match($pattern, $value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        // ...

        $this->app->singleton(Bitstamp::class, function($app){
           return new Bitstamp();
        });
    }
}

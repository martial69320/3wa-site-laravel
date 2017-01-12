<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Hash;
use Validator;
use Request;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Carbon::setLocale('fr');

        Validator::extend('hash', function($attribute, $value, $parameters, $validator){

           return Hash::check($value, $parameters[0]);

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

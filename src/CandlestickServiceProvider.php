<?php

namespace Reccur\Candlestick;

use Illuminate\Support\ServiceProvider;

class CandlestickServiceProvider extends ServiceProvider{

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/candlestick.php', 'candlestick'
        );
        $this->publishes([
            __DIR__.'/config/candlestick.php' => config_path('candlestick.php'),
        ]);
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('candlestick', function($app){
            return new Models\Candlestick();
        });
    }
}
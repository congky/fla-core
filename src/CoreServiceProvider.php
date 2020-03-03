<?php
namespace FLA\Core;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function registerService($className, $serviceName = "") {
        $this->app->singleton($serviceName, function() use ($className) {
            return new $className;
        });
    }
}
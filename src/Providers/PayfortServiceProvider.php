<?php

namespace LaravelPayfort\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelPayfort\Services\PayfortAPI;
use LaravelPayfort\Services\PayfortRedirection;

class PayfortServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    private $configPath = __DIR__ . '/../../config/payfort.php';
    private $translationsPath = __DIR__ . '/../../lang';
    private $viewsPath = __DIR__ . '/../../resources/views';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        # Add config file to service provider publish command
        if (app()->runningInConsole()) {
            $this->publishes([
                $this->configPath => config_path('payfort.php'),
            ], 'config');
        }

        # Load package views files
        $this->loadViewsFrom($this->viewsPath, 'laravel-payfort');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        # Merge application and packages configurations (Only when configurations are not cached)
        if (! app()->configurationIsCached()) {
            $this->mergeConfigFrom(
                $this->configPath,
                'payfort'
            );
        }

        $this->app->bind(PayfortAPI::class, function () {
            return new PayfortAPI(config('payfort'));
        });

        $this->app->bind(PayfortRedirection::class, function () {
            return new PayfortRedirection(config('payfort'));
        });
    }

//    /**
//     * Get the services provided by the provider.
//     *
//     * @return array
//     */
//    public function provides()
//    {
//        \Log::debug('provides');
//        return ['LaravelPayfort\Facades\Payfort'];
//    }
}

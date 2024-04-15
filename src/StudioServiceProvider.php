<?php

namespace Componentstudio\Studio;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Componentstudio\Studio\Livewire\ComponentStage;
use Illuminate\Support\Facades\Blade;

class StudioServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'studio');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'componentstudio');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        Livewire::component('component-stage', ComponentStage::class);

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('componentstudio.php'),
            ], 'config');
        }

		Blade::directive('studio', function ($expression) {
			return "";
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'componentstudio');

        // Register the main class to use with the facade
        $this->app->singleton('studio', function () {
            return new Studio;
        });
    }
}

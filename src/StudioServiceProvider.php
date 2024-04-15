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

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/studio'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/studio'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/studio'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }

		// Blade::directive('studio', function ($expression) {
		// 	// Parse the expression
		// 	$args = str_getcsv($expression, ',');

		// 	//dd($args);

		// 	// Trim and remove quotes from each argument
		// 	$args = array_map(function ($arg) {
		// 		return trim($arg, " '\"");
		// 	}, $args);

		// 	dd($args);
		// 	// Return the array
		/* 	return "<?php return [" . implode(', ', $args) . "]; ?>";
		// });*/

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

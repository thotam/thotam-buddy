<?php

namespace Thotam\ThotamBuddy;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;
use Thotam\ThotamBuddy\DataTables\BuddyCaNhanDataTable;
use Thotam\ThotamBuddy\Http\Livewire\BuddyCaNhanLivewire;

class ThotamBuddyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'thotam-buddy');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'thotam-buddy');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('thotam-buddy.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/thotam-buddy'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/thotam-buddy'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/thotam-buddy'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }

        /*
        |--------------------------------------------------------------------------
        | Seed Service Provider need on boot() method
        |--------------------------------------------------------------------------
        */
        $this->app->register(SeedServiceProvider::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'thotam-buddy');

        // Register the main class to use with the facade
        $this->app->singleton('thotam-buddy', function () {
            return new ThotamBuddy;
        });

        if (class_exists(Livewire::class)) {
            Livewire::component('thotam-buddy::buddy-canhan-livewire', BuddyCaNhanLivewire::class);
            Livewire::component('thotam-buddy::buddy-canhan-datatable', BuddyCaNhanDataTable::class);
        }
    }
}

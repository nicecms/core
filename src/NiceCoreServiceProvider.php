<?php

namespace Nice\Core;

use Illuminate\Support\ServiceProvider;

/**
 * Class NiceCoreServiceProvider
 * @package Nice\Core
 */
class NiceCoreServiceProvider extends ServiceProvider
{

    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('nice_entity_service', function ($app) {
            return new EntityService();
        });

        $this->app->singleton('nice_type_registry', function ($app) {
            return new TypeRegistry();
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../config/nice.php', 'nice'
        );

    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nice');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->publishes([
            __DIR__ . '/../config/nice.php' => config_path('nice.php')
        ]);

    }


}

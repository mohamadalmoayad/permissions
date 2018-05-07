<?php

namespace Almoayad\Permissions;

use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadViewsFrom(__DIR__ . '/views', 'permissions');
        
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }
}

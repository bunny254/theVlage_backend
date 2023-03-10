<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Permission::get()->map(function ($permission) {
            \Gate::define($permission->slug, function ($user) use ($permission) {
                return $user->hasPermission($permission);
            });
        });
    }
}

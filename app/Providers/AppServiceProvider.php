<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Blade authorization helpers for roles and permissions
        Blade::if('role', function (string $role) {
            $user = Auth::user();
            return $user instanceof \App\Models\User ? $user->hasRole($role) : false;
        });

        Blade::if('anyrole', function (...$roles) {
            $user = Auth::user();
            return $user instanceof \App\Models\User ? $user->hasAnyRole($roles) : false;
        });

        Blade::if('perm', function (string $permission) {
            $user = Auth::user();
            return $user instanceof \App\Models\User ? $user->hasPermission($permission) : false;
        });

        Blade::if('anyperm', function (...$permissions) {
            $user = Auth::user();
            return $user instanceof \App\Models\User ? $user->hasAnyPermission($permissions) : false;
        });
    }
}

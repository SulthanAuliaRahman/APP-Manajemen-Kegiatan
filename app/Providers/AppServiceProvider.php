<?php

namespace App\Providers;

use App\Services\MenuService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

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
        view()->composer('layouts.app', function ($view) {
            $user = Auth::check() ? [
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'role' => Auth::user()->role,
            ] : [
                'name' => 'Guest',
                'email' => '',
                'role' => 'mahasiswa',
            ];
            $menuItems = MenuService::getMenuItems($user['role']);
            $view->with(compact('user', 'menuItems'));
        });
    }
}

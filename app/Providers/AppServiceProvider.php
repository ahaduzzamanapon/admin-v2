<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\ThemeComposer;
use App\Services\CartService;
use App\Services\SettingsService;
use App\Services\InventoryService;
use App\Services\OrderService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SettingsService::class);
        $this->app->singleton(CartService::class);
        $this->app->singleton(InventoryService::class);
        $this->app->bind(OrderService::class, function ($app) {
            return new OrderService($app->make(InventoryService::class));
        });
    }

    public function boot(): void
    {
        // Admin sidebar menus
        View::composer('admin.layouts.sidebar', function ($view) {
            $view->with('menus', \App\Models\Menu::whereNull('parent_id')->with('children')->orderBy('order')->get());
        });

        // Inject theme settings into ALL views
        View::composer('*', ThemeComposer::class);

        // Inject categories into shop layout
        View::composer('layouts.shop', \App\View\Composers\CategoryComposer::class);
    }
}


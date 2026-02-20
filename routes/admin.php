<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('login', [AuthController::class, 'loginPost'])->name('admin.login.post');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::post('menus/order', [\App\Http\Controllers\Admin\MenuController::class, 'updateOrder'])->name('admin.menus.order')->middleware('permission:menus.edit');
        Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class)->names('admin.menus')->middleware('permission:menus.browse');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users')->middleware('permission:users.browse');
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class)->names('admin.roles')->middleware('permission:roles.browse');
        Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class)->names('admin.permissions')->middleware('permission:permissions.browse');

        Route::get('crud-builder', [\App\Http\Controllers\Admin\CrudBuilderController::class, 'index'])->name('crud-builder.index');
        Route::post('crud-builder/generate', [\App\Http\Controllers\Admin\CrudBuilderController::class, 'generate'])->name('crud-builder.generate');
        Route::get('crud-builder/models', [\App\Http\Controllers\Admin\CrudBuilderController::class, 'getModels'])->name('crud-builder.get-models');
        Route::get('crud-builder/model-columns', [\App\Http\Controllers\Admin\CrudBuilderController::class, 'getModelColumns'])->name('crud-builder.get-model-columns');

        Route::get('theme', [\App\Http\Controllers\Admin\ThemeController::class, 'index'])->name('admin.theme.index')->middleware('permission:theme.browse');
        Route::post('theme', [\App\Http\Controllers\Admin\ThemeController::class, 'update'])->name('admin.theme.update')->middleware('permission:theme.edit');
        Route::post('theme/apply', [\App\Http\Controllers\Admin\ThemeController::class, 'applyPreset'])->name('admin.theme.apply')->middleware('permission:theme.edit');
        Route::post('theme/preset', [\App\Http\Controllers\Admin\ThemeController::class, 'storePreset'])->name('admin.theme.preset.store')->middleware('permission:theme.edit');
        Route::get('theme/preset/{id}/edit', [\App\Http\Controllers\Admin\ThemeController::class, 'editPreset'])->name('admin.theme.preset.edit')->middleware('permission:theme.edit');
        Route::put('theme/preset/{id}', [\App\Http\Controllers\Admin\ThemeController::class, 'updatePreset'])->name('admin.theme.preset.update')->middleware('permission:theme.edit');
        Route::delete('theme/preset/{id}', [\App\Http\Controllers\Admin\ThemeController::class, 'destroyPreset'])->name('admin.theme.preset.destroy')->middleware('permission:theme.edit');

        Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index')->middleware('permission:settings.browse');
        Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update')->middleware('permission:settings.edit');

        // ── E-Commerce ─────────────────────────────────────────────────────────────
        // Categories
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)
            ->names('admin.categories')
            ->middleware('permission:categories.view');
        Route::post('categories/{id}/restore', [\App\Http\Controllers\Admin\CategoryController::class, 'restore'])
            ->name('admin.categories.restore');

        // Products
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)
            ->names('admin.products')
            ->middleware('permission:products.view');
        Route::post('products/{id}/restore', [\App\Http\Controllers\Admin\ProductController::class, 'restore'])
            ->name('admin.products.restore');

        // Orders
        Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index')->middleware('permission:orders.view');
        Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show')->middleware('permission:orders.view');
        Route::post('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.status')->middleware('permission:orders.update_status');
        Route::post('orders/{order}/cancel', [\App\Http\Controllers\Admin\OrderController::class, 'cancel'])->name('admin.orders.cancel')->middleware('permission:orders.update_status');
        Route::get('orders/{order}/invoice', [\App\Http\Controllers\Admin\OrderController::class, 'invoice'])->name('admin.orders.invoice')->middleware('permission:orders.print_invoice');

        // Customers (read-only)
        Route::get('customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers.index')->middleware('permission:customers.view');
        Route::get('customers/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('admin.customers.show')->middleware('permission:customers.view');

        // Inventory
        Route::get('inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('admin.inventory.index')->middleware('permission:inventory.view');
        Route::post('inventory/{product}/adjust', [\App\Http\Controllers\Admin\InventoryController::class, 'adjust'])->name('admin.inventory.adjust')->middleware('permission:inventory.adjust');

        // Reports
        Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index')->middleware('permission:reports.view');

        // Pages
        Route::resource('pages', \App\Http\Controllers\Admin\PageController::class)
            ->names('admin.pages');

        require base_path('routes/crud.php');
    });
});

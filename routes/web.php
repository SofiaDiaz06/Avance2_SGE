<?php

use App\Http\Controllers\ActiveRoleController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\Settings\BrandingController;
use App\Http\Controllers\Settings\PermissionController;
use App\Http\Controllers\Settings\RoleController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Settings\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/login'));

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rol activo (usuarios con varios roles)
    Route::get('rol-activo', [ActiveRoleController::class, 'edit'])->name('active-role.edit');
    Route::put('rol-activo', [ActiveRoleController::class, 'update'])->name('active-role.update');

    // Productos (con Soft Delete, restore, Excel y protección de módulo)
    Route::middleware('module:products')->group(function () {
        // Excel: exportar e importar productos (Clase 13) - Declaradas ANTES de Route::resource
        Route::get('products/exportar', [ExcelController::class, 'exportProducts'])->name('products.export');
        Route::get('products/importar', [ExcelController::class, 'importForm'])->name('products.import');
        Route::post('products/importar', [ExcelController::class, 'import'])->name('products.import.store');
        Route::get('products/plantilla', [ExcelController::class, 'template'])->name('products.template');

        Route::get('products/trash', [ProductController::class, 'trash'])->name('products.trash');
        Route::patch('products/{product}/restore', [ProductController::class, 'restore'])
            ->withTrashed()->name('products.restore');
        Route::resource('products', ProductController::class);
    });

    // Categorías (con Soft Delete, restore y protección de módulo)
    Route::middleware('module:categories')->group(function () {
        Route::get('categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');
        Route::patch('categories/{category}/restore', [CategoryController::class, 'restore'])
            ->withTrashed()->name('categories.restore');
        Route::resource('categories', CategoryController::class);
    });

    // Clientes (con Soft Delete, restore y protección de módulo)
    Route::middleware('module:clients')->group(function () {
        Route::patch('clients/{client}/restore', [ClientController::class, 'restore'])
            ->withTrashed()->name('clients.restore');
        Route::resource('clients', ClientController::class)->except('show');
    });

    // Proveedores (con Soft Delete, restore y protección de módulo)
    Route::middleware('module:providers')->group(function () {
        Route::patch('providers/{provider}/restore', [ProviderController::class, 'restore'])
            ->withTrashed()->name('providers.restore');
        Route::resource('providers', ProviderController::class)->except('show');
    });

    // Ventas (con PDF, Excel y protección de módulo)
    Route::middleware('module:sales')->group(function () {
        // Excel: exportar ventas (Clase 13)
        Route::get('sales/exportar', [ExcelController::class, 'exportSales'])->name('sales.export');

        Route::get('sales/{sale}/pdf', [SaleController::class, 'pdf'])->name('sales.pdf');
        Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    });

    // Compras (con recepción, PDF y protección de módulo)
    Route::middleware('module:purchases')->group(function () {
        Route::patch('purchases/{purchase}/receive', [PurchaseController::class, 'receive'])->name('purchases.receive');
        Route::get('purchases/{purchase}/pdf', [PurchaseController::class, 'pdf'])->name('purchases.pdf');
        Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    });

    // Inventario: kardex y ajustes (Clase 12, con protección de módulo)
    Route::middleware('module:inventory')->group(function () {
        Route::get('inventario/kardex', [InventoryController::class, 'kardex'])->name('inventory.kardex');
        Route::get('inventario/kardex/{product}/pdf', [InventoryController::class, 'pdf'])
            ->withTrashed()->name('inventory.pdf');
        Route::get('inventario/ajustes/{product}', [InventoryController::class, 'adjust'])
            ->withTrashed()->name('inventory.adjust');
        Route::post('inventario/ajustes/{product}', [InventoryController::class, 'storeAdjustment'])
            ->withTrashed()->name('inventory.adjust.store');
    });

    // Auditoría (Clase 12, con protección de módulo)
    Route::middleware('module:audit')->group(function () {
        Route::get('auditoria', [AuditController::class, 'index'])->name('audit.index');
    });

    // Configuración: usuarios, roles, permisos e identidad corporativa
    Route::prefix('configuracion')->name('settings.')->group(function () {
        Route::get('/', SettingsController::class)->name('index');
        Route::patch('usuarios/{user}/estado', [UserController::class, 'toggle'])->name('users.toggle');
        Route::resource('usuarios', UserController::class)
            ->except(['show', 'destroy'])
            ->parameters(['usuarios' => 'user'])
            ->names('users');
        Route::resource('roles', RoleController::class)->except('show');
        Route::get('permisos', [PermissionController::class, 'index'])->name('permissions.index');
        Route::put('permisos', [PermissionController::class, 'updateMatrix'])->name('permissions.matrix');
        Route::post('permisos', [PermissionController::class, 'store'])->name('permissions.store');
        Route::delete('permisos/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

        // Identidad corporativa (Configuración visual)
        Route::get('identidad', [BrandingController::class, 'edit'])->name('branding.edit');
        Route::put('identidad', [BrandingController::class, 'update'])->name('branding.update');
    });
});

require __DIR__.'/auth.php';
<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\ItemController;

Route::inertia('/', 'Dashboard', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::get('/api/users', [UserRoleController::class, 'get_users']);
Route::get('/api/roles', [UserRoleController::class, 'get_roles']);
Route::post('/api/assign-role', [UserRoleController::class, 'assign_role']);
Route::get('/api/menu-items', [UserRoleController::class, 'get_menu_items']);
Route::get('/api/menu-permissions', [UserRoleController::class, 'get_menu_permissions']);
Route::post('/api/menu-permissions', [UserRoleController::class, 'save_menu_permissions']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('/admin/menu-permissions', 'admin/MenuPermissions')->name('admin.menu-permissions');
});

// main contents
Route::get('/api/items', [ItemController::class, 'index']);
Route::inertia('/items', 'ItemsList')->name('items.index');

require __DIR__.'/settings.php';

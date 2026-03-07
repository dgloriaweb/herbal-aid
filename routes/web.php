<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\UserRoleController;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::get('/api/users', [UserRoleController::class, 'get_users']);
Route::get('/api/roles', [UserRoleController::class, 'get_roles']);
Route::post('/api/assign-role', [UserRoleController::class, 'assign_role']);

require __DIR__.'/settings.php';

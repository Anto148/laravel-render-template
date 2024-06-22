<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AppConfigurationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('test', function(){

    return 'test';
});
//Auth
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::delete('logout', [AuthController::class, 'logout'])->name('logout');

// App Configurations
Route::get('app-configurations', [AppConfigurationController::class, 'index'])->name('app-configurations.index');
Route::get('app-configurations/{app_configuration}', [AppConfigurationController::class, 'show'])->name('app-configurations.show');
Route::post('app-configurations/search', [AppConfigurationController::class, 'search'])->name('app-configurations.search');

Route::group(['middleware' => ['auth:sanctum']], function () {

    // User
    Route::post('users/search', [UsersController::class, 'search'])->name('users.search');
    Route::apiResource('users', UsersController::class);

    // Roles
    Route::apiResource('roles', RoleController::class);
    Route::post('roles/search', [RoleController::class, 'search'])->name('roles.search');
    Route::post('roles/permissions/manage', [RoleController::class, 'permission_manage'])->name('roles.permissions.manage');

    //Permmission
    Route::apiResource('permissions', PermissionController::class);
    Route::post('permissions/search', [PermissionController::class, 'search'])->name('permissions.search');

});

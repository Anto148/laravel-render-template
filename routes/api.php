<?php

use App\Models\Categorie;
use App\Models\Realisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ActeurController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RealisateurController;
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

// Categories
Route::get('categories', [CategorieController::class, 'index'])->name('categories.index');
Route::get('categories/{category}', [CategorieController::class, 'show'])->name('categories.show');
Route::post('categories/search', [CategorieController::class, 'search'])->name('categories.search');

// Acteurs
Route::get('acteurs', [ActeurController::class, 'index'])->name('acteurs.index');
Route::get('acteurs/{auteur}', [ActeurController::class, 'show'])->name('acteurs.show');
Route::post('acteurs/search', [ActeurController::class, 'search'])->name('acteurs.search');

// Realisateurs
Route::get('realisateurs', [RealisateurController::class, 'index'])->name('realisateurs.index');
Route::get('realisateurs/{realisateur}', [RealisateurController::class, 'show'])->name('realisateurs.show');
Route::post('realisateurs/search', [RealisateurController::class, 'search'])->name('realisateurs.search');

//Films
Route::get('films', [FilmController::class, 'index'])->name('films.index');
Route::get('films/{film}', [FilmController::class, 'show'])->name('films.show');
Route::post('films/search', [FilmController::class, 'search'])->name('films.search');


Route::group(['middleware' => ['auth:sanctum']], function () {

    // User
    Route::post('users/search', [UsersController::class, 'search'])->name('users.search');
    Route::apiResource('users', UsersController::class);

    // Categorie
    Route::apiResource('categories', CategorieController::class)->except(['index','show']);

    // Acteur
    Route::apiResource('acteurs', ActeurController::class)->except(['index','show']);

    // Realisateur
    Route::apiResource('realisateurs', RealisateurController::class)->except(['index','show']);

    // Film
    Route::apiResource('films', FilmController::class)->except(['index','show']);

    // Roles
    Route::apiResource('roles', RoleController::class);
    Route::post('roles/search', [RoleController::class, 'search'])->name('roles.search');
    Route::post('roles/permissions/manage', [RoleController::class, 'permission_manage'])->name('roles.permissions.manage');

    //Permmission
    Route::apiResource('permissions', PermissionController::class);
    Route::post('permissions/search', [PermissionController::class, 'search'])->name('permissions.search');


});

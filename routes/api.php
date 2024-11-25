<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ActeurController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectionController;
use App\Http\Controllers\RealisateurController;
use App\Http\Controllers\TypeProjectionController;
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
Route::controller(AppConfigurationController::class)->group(function () {
    Route::get('app-configurations', 'index')->name('app-configurations.index');
    Route::get('app-configurations/{app_configuration}', 'show')->name('app-configurations.show');
    Route::post('app-configurations/search', 'search')->name('app-configurations.search');
});

// Categories
Route::controller(CategorieController::class)->group(function () {
    Route::get('categories', 'index')->name('categories.index');
    Route::get('categories/{category}', 'show')->name('categories.show');
    Route::post('categories/search', 'search')->name('categories.search');
});

// Acteurs
Route::controller(ActeurController::class)->group(function () {
    Route::get('acteurs', 'index')->name('acteurs.index');
    Route::get('acteurs/{auteur}', 'show')->name('acteurs.show');
    Route::post('acteurs/search', 'search')->name('acteurs.search');
});

// Realisateurs
Route::controller(RealisateurController::class)->group(function () {
    Route::get('realisateurs', 'index')->name('realisateurs.index');
    Route::get('realisateurs/{realisateur}', 'show')->name('realisateurs.show');
    Route::post('realisateurs/search', 'search')->name('realisateurs.search');
});

//Films
Route::controller(FilmController::class)->group(function () {
    Route::get('films', 'index')->name('films.index');
    Route::get('films/{film}', 'show')->name('films.show');
    Route::post('films/search', 'search')->name('films.search');
});

// Type Projections
Route::controller(TypeProjectionController::class)->group(function () {
    Route::get('type-projections', 'index')->name('type-projections.index');
    Route::get('type-projections/{type_projection}', 'show')->name('type-projections.show');
    Route::post('type-projections/search', 'search')->name('type-projections.search');
});

// Projection
Route::controller(ProjectionController::class)->group(function () {
    Route::get('projections', 'index')->name('projections.index');
    Route::get('projections/{projection}', 'show')->name('projections.show');
    Route::post('projections/search', 'search')->name('projections.search');
    Route::post('projections/week', 'projectionsDeLaSemaine')->name('projections.week');
});

// Tickets
Route::controller(TicketController::class)->group(function () {
    Route::get('tickets', 'index')->name('tickets.index');
    Route::get('tickets/{ticket}', 'show')->name('tickets.show');
    Route::post('tickets/search', 'search')->name('tickets.search');
    Route::get('tickets/payment-confirmation', 'confirmPayment')->name('tickets.payment-confirmation');
});


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
    Route::apiResource('films', FilmController::class)->except(['index','show','search']);

    // Type Projection
    Route::apiResource('type-projections', TypeProjectionController::class)->except(['index','show','search']);

    // Projection
    Route::apiResource('projections', ProjectionController::class)->except('index','show');

    // Roles
    Route::apiResource('roles', RoleController::class);
    Route::post('roles/search', [RoleController::class, 'search'])->name('roles.search');
    Route::post('roles/permissions/manage', [RoleController::class, 'permission_manage'])->name('roles.permissions.manage');

    //Permmission
    Route::apiResource('permissions', PermissionController::class);
    Route::post('permissions/search', [PermissionController::class, 'search'])->name('permissions.search');

});

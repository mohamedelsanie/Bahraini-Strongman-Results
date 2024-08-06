<?php

use App\Http\Controllers\Admin\GamesController;
use App\Http\Controllers\Admin\PlayersController;
use App\Http\Controllers\Admin\ResultsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('checksite')->namespace('App\Http\Controllers')->group(function (){
    // Home Routes
    Route::get('/', 'FrontController@index')->name('homepage');
    Route::post('search', 'FrontController@search')->name('search');
    Route::get('/closed', 'FrontController@closed')->name('closed');
    Route::get('/dashboard', 'App\Http\Controllers\FrontController@orders')->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
});

Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->group(function (){
   Route::namespace('Auth')->middleware('guest:admin')->group(function (){
       Route::get('login','AuthenticatedSessionController@create')->name('login');
       Route::post('login','AuthenticatedSessionController@store')->name('adminlogin');
       Route::put('/password', 'PasswordController@update')->name('password.update');
   });
   Route::middleware('admin')->group(function(){

       Route::get('/','HomeController@base')->name('base');
       // Roles Routes
       Route::resource('roles', RoleController::class);
       Route::get('roles/{id}/delete','RoleController@destroy')->name('roles.delete');
       Route::post('roles/destroy_all','RoleController@destroy_all')->name('roles.destroy_all');
       Route::post('roles/search','RoleController@search')->name('roles.search');
       // Permissions Routes
       Route::resource('permissions', PermissionsController::class);
       Route::get('permissions/{id}/delete','PermissionsController@destroy')->name('permissions.delete');
       Route::post('permissions/destroy_all','PermissionsController@destroy_all')->name('permissions.destroy_all');
       Route::post('permissions/search','PermissionsController@search')->name('permissions.search');
       // Users Routes
       Route::get('users/archive', 'UsersController@archive')->name('users.archive');
       Route::resource('users', UsersController::class);
       Route::post('users/destroy_all','UsersController@destroy_all')->name('users.destroy_all');
       Route::get('users/{id}/delete','UsersController@destroy')->name('users.delete');
       Route::post('users/restore_all','UsersController@restore_all')->name('users.restore_all');
       Route::get('users/{id}/restore','UsersController@restore')->name('users.restore');
       Route::post('users/search','UsersController@search')->name('users.search');
       // Admins Routes
       Route::get('admins/archive', 'AdminsController@archive')->name('admins.archive');
       Route::resource('admins', AdminsController::class);
       Route::post('admins/destroy_all','AdminsController@destroy_all')->name('admins.destroy_all');
       Route::get('admins/{id}/delete','AdminsController@destroy')->name('admins.delete');
       Route::post('admins/restore_all','AdminsController@restore_all')->name('admins.restore_all');
       Route::get('admins/{id}/restore','AdminsController@restore')->name('admins.restore');
       Route::post('admins/search','AdminsController@search')->name('admins.search');
       // Settings Routes
       Route::get('settings','SettingsController@form')->name('settings');
       Route::post('settings/store','SettingsController@store')->name('settings.store');
       // Media Routes
       Route::get('media/archive', 'MediaController@archive')->name('media.archive');
       Route::get('media','MediaController@index')->name('media.index');
       Route::post('media/upload','MediaController@upload')->name('media.upload');
       Route::get('media/{id}/show','MediaController@show')->name('media.show');
       Route::get('media/{id}/edit','MediaController@edit')->name('media.edit');
       Route::put('media/{id}/update','MediaController@update')->name('media.update');
       Route::post('media/destroy_all','MediaController@destroy_all')->name('media.destroy_all');
       Route::get('media/{id}/delete','MediaController@destroy')->name('media.delete');
       Route::post('media/restore_all','MediaController@restore_all')->name('media.restore_all');
       Route::get('media/{id}/restore','MediaController@restore')->name('media.restore');
       Route::post('media/search','MediaController@search')->name('media.search');

       // Dashboard Routes
       Route::get('/dashboard','HomeController@index')->name('dashboard');
       Route::get('/profile', 'ProfileController@edit')->name('profile.edit');
       Route::patch('/profile', 'ProfileController@update')->name('profile.update');
       Route::delete('/profile', 'ProfileController@destroy')->name('profile.destroy');
       Route::get('sidebar','HomeController@sidebar')->name('sidebar');

       // Players Routes
       Route::get('players/archive', 'PlayersController@archive')->name('players.archive');
       Route::get('players/all', [PlayersController::class, 'getPlayersDatatable'])->name('players.all');
       Route::get('players/trashed', [PlayersController::class, 'getTrshedPlayersDatatable'])->name('players.trashed');
       Route::resource('players', PlayersController::class);
       Route::post('players/delete','PlayersController@delete')->name('players.delete');
       Route::get('players/{id}/restore','PlayersController@restore')->name('players.restore');
       // Games Routes
       Route::get('games/archive', 'GamesController@archive')->name('games.archive');
       Route::get('games/all', [GamesController::class, 'getGamesDatatable'])->name('games.all');
       Route::get('games/trashed', [GamesController::class, 'getTrshedGamesDatatable'])->name('games.trashed');
       Route::resource('games', GamesController::class);
       Route::post('games/delete','GamesController@delete')->name('games.delete');
       Route::get('games/{id}/restore','GamesController@restore')->name('games.restore');
       // Results Routes
       Route::get('results/page', [ResultsController::class, 'page'])->name('results.page');
       Route::get('results/all', [ResultsController::class, 'getAllResultsDatatable'])->name('results.all');
       Route::get('results/{id}/add',[ResultsController::class, 'add'])->name('results.add');
       Route::post('results/reset',[ResultsController::class, 'reset'])->name('results.reset');
       Route::get('results/category/{slug}', [ResultsController::class, 'getLight'])->name('results.category');
       Route::get('results/category/{slug}/all', [ResultsController::class, 'getResultsDatatable'])->name('results.category.all');
       Route::resource('results', ResultsController::class);

       Route::get('cat/results/{slug?}', [ResultsController::class, 'cats'])->name('cat.results');
       Route::get('cat/results/{slug}/games', [ResultsController::class, 'games'])->name('games.results');
       Route::get('cat/results/{slug}/game/{id}', [ResultsController::class, 'game'])->name('game.results');
       Route::get('cat/results/{slug}/game/{id}/all', [ResultsController::class, 'getGamesResultsDatatable'])->name('game.results.all');


       Route::get('final/results/{slug?}', [ResultsController::class, 'finalCats'])->name('final.results');
       Route::get('final/results/{slug}/all', [ResultsController::class, 'getFinalResultsDatatable'])->name('final.results.all');

   });
    Route::post('logout','Auth\AuthenticatedSessionController@destroy')->name('logout');
});

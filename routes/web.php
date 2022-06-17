<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::get('/', [
    'uses' => 'App\Http\Controllers\HomeController@index',
    'as' => 'home'
]);

// Catalog
Route::get('/catalog', [
    'uses' => 'App\Http\Controllers\CatalogController@index',
    'as' => 'catalog'
]);

// Collection
Route::get('/collections', [
    'uses' => 'App\Http\Controllers\CollectionController@index',
    'as' => 'collections'
]);

Route::get('/collection/{id}', [
    'uses' => 'App\Http\Controllers\CollectionController@collection',
    'as' => 'collection'
]);

// Film
Route::get('/film/{film}', [
    'uses' => 'App\Http\Controllers\FilmController@film',
    'as' => 'film'
]);

Route::post('/add_del_film_in_list', [
    'uses' => 'App\Http\Controllers\FilmController@addDelFilmInList',
    'as' => 'add_del_film_in_list'
]);

Route::post('/add_del_film_in_favorites', [
    'uses' => 'App\Http\Controllers\FilmController@addDelFilmInFavorites',
    'as' => 'add_del_film_in_favorites'
]);

Route::post('/add_del_emoji', [
    'uses' => 'App\Http\Controllers\FilmController@addDelEmoji',
    'as' => 'add_del_emoji'
]);

Route::post('/rate_film', [
    'uses' => 'App\Http\Controllers\FilmController@rateFilm',
    'as' => 'rate_film'
]);

Route::post('/add_del_tag', [
    'uses' => 'App\Http\Controllers\FilmController@addDelTag',
    'as' => 'add_del_tag'
]);

// Search
Route::get('/search', [
    'uses' => 'App\Http\Controllers\SearchController@index',
    'as' => 'search'
]);

Route::post('/filter', [
    'uses' => 'App\Http\Controllers\SearchController@filter',
    'as' => 'filter'
]);

// Profile
Route::get('/profile', [
    'uses' => 'App\Http\Controllers\ProfileController@index',
    'as' => 'profile'
]);

Route::get('/profile_list/{id}', [
    'uses' => 'App\Http\Controllers\ProfileController@list',
    'as' => 'profile_list'
]);

Route::post('/move_film_from_list_to_list', [
    'uses' => 'App\Http\Controllers\ProfileController@moveFilmFromListToList',
    'as' => 'move_film_from_list_to_list'
]);

Route::get('/profile_edit', [
    'uses' => 'App\Http\Controllers\ProfileController@edit',
    'as' => 'profile_edit'
]);

Route::post('/profile_update', [
    'uses' => 'App\Http\Controllers\ProfileController@update',
    'as' => 'profile_update'
]);

Route::get('/profile_public/{id}', [
    'uses' => 'App\Http\Controllers\ProfileController@public',
    'as' => 'profile_public'
]);

Route::post('/upload_user_image', [
    'uses' => 'App\Http\Controllers\ProfileController@uploadUserImage',
    'as' => 'upload_user_image'
]);

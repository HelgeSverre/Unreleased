<?php

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


Route::get('/', 'TrackController@index')->name('track.index');

Route::get('/tracks/create', 'TrackController@create')->name('track.create');
Route::post('/tracks/create', 'TrackController@store')->name('track.store');
Route::post('/tracks/{id}/update', 'TrackController@update')->name('track.update');
Route::get('/tracks/{id}/edit', 'TrackController@edit')->name('track.edit');

Route::get('/genres', 'GenreController@index')->name('genre.index');
Route::get('/genres/{id}', 'GenreController@show')->name('genre.show');


Route::get('/artists', 'ArtistController@index')->name('artist.index');
Route::get('/artists/create', 'ArtistController@create')->name('artist.create');
Route::get('/artists/{id}', 'ArtistController@show')->name('artist.show');
Route::post('/artists/create', 'ArtistController@store')->name('artist.store');
Route::get('/artists/{id}/edit', 'ArtistController@edit')->name('artist.edit');
Route::post('/artists/{id}', 'ArtistController@update')->name('artist.update');

Route::group(["prefix" => "/api"], function () {

    Route::get('/artists', 'Api\ArtistController@index')->name('api.artist.index');
    Route::post('/artists', 'Api\ArtistController@store')->name('api.artist.store');

    Route::get('/genres', 'Api\GenreController@index')->name('api.genre.index');
    Route::post('/genres', 'Api\GenreController@store')->name('api.genre.store');

    Route::get('/tracks', 'Api\TrackController@index')->name('api.track.index');
});

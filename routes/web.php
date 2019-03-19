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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

// Library
Route::resource('library', 'LibraryController');

Route::get('categories/create', 'LibrarySectionController@create')->name('categories.create');
Route::post('categories', 'LibrarySectionController@store')->name('categories.store');
Route::get('{librarySlug}/{sectionSlug}', 'LibrarySectionController@show')->name('section.show');

Route::get('/home', 'HomeController@index')->name('home');

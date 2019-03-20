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
Route::resource('/library', 'LibraryController');
// Tags
Route::resource('/tags', 'TagsController');
// Admin
Route::resource('admin', 'AdminController');


Route::get('/categories/create', 'LibrarySectionController@create')->name('categories.create');
Route::post('/categories', 'LibrarySectionController@store')->name('categories.store');
Route::get('/{librarySlug}/{sectionSlug}', 'LibrarySectionController@show')->name('section.show');

// Books
Route::get('/{sectionSlug}/books/create', 'LibraryBooksController@create')->name('books.create');
Route::post('/books', 'LibraryBooksController@store')->name('books.store');
Route::get('/{librarySlug}/{sectionSlug}/{bookSlug}/details', 'LibraryBooksController@show')->name('books.show');
Route::get('/{librarySlug}/{sectionSlug}/{bookSlug}/recent', 'LibraryBooksController@recent')->name('books.recent');

// Route::resource('/tags', 'TagsController@create');
// Route::post('/tags', 'TagsController@store')->name('tags.store');

Route::get('/home', 'HomeController@index')->name('home');

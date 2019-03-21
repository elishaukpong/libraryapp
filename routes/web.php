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


// Route::resource('/categories', 'LibrarySectionController');
Route::get('/categories/create', 'LibrarySectionController@create')->name('categories.create');
Route::post('/categories', 'LibrarySectionController@store')->name('categories.store');
Route::get('/categories/{librarySlug}/{sectionSlug}/edit', 'LibrarySectionController@edit')->name('categories.edit');
Route::patch('/categories/{librarySection}', 'LibrarySectionController@update')->name('categories.update');
Route::delete('/categories/{librarySection}', 'LibrarySectionController@destroy')->name('categories.destroy');
Route::get('/{librarySlug}/{sectionSlug}', 'LibrarySectionController@show')->name('section.show');

// Books
Route::get('/{sectionSlug}/books/create', 'LibraryBooksController@create')->name('books.create');
Route::post('/books', 'LibraryBooksController@store')->name('books.store');
Route::get('/books/{bookId}/edit', 'LibraryBooksController@edit')->name('book.edit');
Route::patch('/books/{bookId}', 'LibraryBooksController@update')->name('book.update');
Route::get('/books/borrowed', 'BorrowBooksController@index')->name('books.borrowed.all');

Route::get('/{librarySlug}/{sectionSlug}/{bookSlug}/details', 'LibraryBooksController@show')->name('books.show');
Route::get('/{librarySlug}/{sectionSlug}/{bookSlug}/borrow', 'BorrowBooksController@borrow')->name('books.borrow');
Route::get('/{librarySlug}/{sectionSlug}/{bookSlug}/return', 'BorrowBooksController@return')->name('books.return');
Route::get('/{librarySlug}/{sectionSlug}/{bookSlug}/purchase', 'LibraryBooksController@purchase')->name('books.purchase');
Route::get('/{librarySlug}/{sectionSlug}/{bookSlug}/recent', 'LibraryBooksController@recent')->name('books.recent');

// Route::resource('/tags', 'TagsController@create');
// Route::post('/tags', 'TagsController@store')->name('tags.store');

Route::get('/home', 'HomeController@index')->name('home');

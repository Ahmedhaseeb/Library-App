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

Route::get('/', "userController@showLoginForm")->name('home')->middleware('role:all');

Route::get('/403',function(){
	return view('403');
});

// Author/Book Routes
Route::get('/authors-books','authorsController@showBookAuthorsForm')->middleware('role:admin')->name('bookAuthorsForm');
Route::post('/authors-books','authorsController@storeBookAuthors')->middleware('role:admin')->name('storeBookAuthors');
Route::post('/get-authors','authorsController@getAuthorsByBookId')->middleware('role:admin');

// Resource Routes. Admin - Books - Authors
Route::resource('/admin','adminController')->middleware('role:admin');
Route::resource('/books','booksController')->middleware('role:admin');
Route::resource('/authors','authorsController')->middleware('role:admin');

// issue book
Route::get('/issue-book','booksController@showIssueBookForm')->middleware('role:admin')->name('issueBookForm');
Route::post('/issue-book','booksController@issueBook')->middleware('role:admin')->name('issueBook');

// Student Routes
Route::get('/student','studentsController@getAvailableBooks')->middleware('role:student');
Route::get('/issued-books','studentsController@issuedBooks')->middleware('role:student');

// Login/Logout Routes
Route::get('/login','userController@showLoginForm')->name('login')->middleware('role:all');
Route::post('/login','userController@loginUser')->middleware('role:all');
Route::post('/logout', 'userController@logout')->name('logout')->middleware('role:all');

// User Registration
Route::get('/register','userController@showRegisterUserForm')->name('register')->middleware('role:all');
Route::post('/register','userController@registerUser')->middleware('role:all');

// Report Routes
Route::get('/reports/all-books','reportsController@getAllBooks')->middleware('role:admin');
Route::get('/reports/books-issued','reportsController@booksIssued')->middleware('role:admin');
Route::get('/reports/avail-books','reportsController@availableBooks')->middleware('role:admin');

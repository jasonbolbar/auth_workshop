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

Route::prefix('login')->group(function(){
	Route::get('/saml', 'SamlController@login')->middleware('auth');
});

Route::prefix('logout')->group(function(){
    Route::get('/saml', 'SamlController@logout');
});


Route::prefix('metadata')->group(function(){
    Route::get('/saml', function () {
        return response()->file(storage_path('metadata.xml'));
    })->middleware('auth');
});


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

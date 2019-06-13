<?php

use Aacotroneo\Saml2\Saml2Auth;
use Illuminate\Support\Facades\{Auth,Session};

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

Route::get('logout', function(){
    Auth::logout();
    Session::save();
    return redirect('/');
});

Route::get('login', function(){
    return app()->make(Saml2Auth::class)->login();
});

Route::get('/error',function(){
   return 'ERROR';
});

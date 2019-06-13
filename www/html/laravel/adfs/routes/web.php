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

use Aacotroneo\Saml2\Saml2Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

Route::get('logout', function(){
    Auth::logout();
    Session::save();
    return redirect('/');
});

Route::get('login', function(){
    if (Auth::check())
    {
        return redirect('/');
    }
    return app()->make(Saml2Auth::class)->login();
});

Route::get('/error',function(){
    return 'ERROR';
});


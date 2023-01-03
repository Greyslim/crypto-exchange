<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::name('user.')->group(function(){
    Route::view('/main','main')->middleware('auth')->name('main');
 
    Route::get('/login',function(){
        if(Auth::check()){
            return redirect(route('user.main'));
        }
        return view('login');
    })->name('login');
//    Route::post('/login', [])

//    route::get('/logout',[])->name('logout');

    Route::get('/registration',function(){
        if(Auth::check()){
            return redirect(route('user.main'));
        }
        return view('registration');
    })->name('registration');

//    Route::post('/registration', [])
});
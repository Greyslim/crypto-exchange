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

Route::name('user.')->group(function(){
    Route::get('/main', [\App\Http\Controllers\MainController::class, 'index'])->middleware('auth')->name('main');
    // Костыль, нужно будет убрать
    Route::get('/', function () {
        if(Auth::check()){
            return redirect(route('user.main'));
        }
        return view('login');
    });

    Route::get('/login',function(){
        if(Auth::check()){
            return redirect(route('user.main'));
        }
        return view('login');
    })->name('login');
    Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);

    Route::get('/logout',function(){
        Auth::logout();
        return redirect(route('user.login'));
    })->name('logout');

    Route::get('/registration',function(){
        if(Auth::check()){
            return redirect(route('user.main'));
        }
        return view('registration');
    })->name('registration');

    Route::post('/registration', [\App\Http\Controllers\RegistrationController::class, 'save']);


    Route::get('/buy', [\App\Http\Controllers\MainController::class, 'info'])->middleware('auth')->name('buy');
    Route::post('/buy', [\App\Http\Controllers\MainController::class, 'buy'])->middleware('auth');
});
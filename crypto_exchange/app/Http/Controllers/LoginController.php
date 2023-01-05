<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return csrf_token(); 
    }

    public function login(Request $request){
        if(Auth::check()){
            return redirect(route('user.main'));
        }
    
        $formFields = $request->only(['email','password']);

        if (Auth::attempt($formFields)){
            return redirect()->intended(route('user.main'));
        } 

        return redirect(route('user.login'))->withErrors([
            'email' => 'Wrong Email/password'
        ]);
    }
}

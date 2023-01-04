<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request){
      //  dd(\Auth::id());
        $users = User::all();
        return view('main', compact('users'));
    }

    public function buy(Request $request){
        return view('buy');
    }
}

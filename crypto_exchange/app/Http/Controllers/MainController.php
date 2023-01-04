<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request){
        $user_id = \Auth::id();
        $user_coins = \DB::select('call sp_user_coins(?)',array($user_id));
        return view('main', compact('user_coins'));
    }

    public function buy(Request $request){
        return view('buy');
    }
}

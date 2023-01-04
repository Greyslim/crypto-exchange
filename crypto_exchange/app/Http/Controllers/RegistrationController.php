<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function save(Request $request){
        if(Auth::check()){
            return redirect(route('user.main'));
        }

        $validateFields = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(User::where('email', $validateFields['email'])->exists()){
            return redirect(route('user.registration'))->withErrors([
                'email' => 'This email is exist'
            ]);
        };

        $user = User::create($validateFields);

        if($user){
            Auth::login($user);

            // Add Start Coin
            DB::select('call sp_add_start_coin(?)',array($user->id));
            
            // message about receiving coins
            \Session::flash('flash_message','Congratulations, for registration you get 1 USDT and 0.001 BTC');

            return redirect(route('user.main'));
        }

        return redirect(route('user.main'))->withErrors([
            'formError' => 'Error when trying to save user'
        ]);
    }
}

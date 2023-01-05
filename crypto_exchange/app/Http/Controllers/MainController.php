<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Components\ImportCryptoCompareData;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request){
        $user_id = \Auth::id();
        $user_coins = \DB::select('call sp_user_coins(?)',array($user_id));
        return view('main', compact('user_coins'));
    }

    public function buy(Request $request){
        $request->validate([
            'price' => 'required',
            'amount' => 'required',
        ]);

        //Кастыль
        //Refresh price 
        $import = new ImportCryptoCompareData();
        $params = [
            'query' => [
               'fsyms' => 'BTC,USDT',
               'tsyms' => 'USDT,BTC',
            ]
         ];
        $response = $import->client->request('GET','pricemulti',$params);
        $data = $response->getBody()->getContents();
        \DB::select('call sp_resfresh_price(?)',array($data));

        // Validate and Buy 
        $json_data = $request->all();
        $json_data['user_id'] = \Auth::id();
        $json_data = json_encode($json_data);
        $data = \DB::select('call sp_buy_coin(?)',array($json_data));
        
        $data = json_decode($data['0']->p_data);

        if ($data->code == 200){
            if(\Auth::check()){
                return redirect(route('user.main'));
            }
        } else {
            \Session::flash('flash_message',$data->msg);
            \Session::flash('alert-class', 'alert-danger'); 

            if(\Auth::check()){
                return redirect(route('user.buy', ['id' => $data->id]));
            }
        }
    }

    public function info(Request $request){
        $coin_id = $request->id;
        $user_id = \Auth::id();

        $data = \DB::select('call sp_get_buy_info(?,?)',array($user_id, $coin_id));

        if($data){
            $buy_info = $data['0'];
            return view('buy', compact('buy_info'));
        } else
        {
            if(\Auth::check())
                return redirect()->intended(route('user.main'));
            else
                return redirect()->intended(route('user.login'));
        }
    }
}

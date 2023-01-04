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
        $coin_id = $request->id;
        $user_id = \Auth::id();

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


        $buy_info = \DB::select('call sp_get_buy_info(?,?)',array($user_id, $coin_id));
        return view('buy', compact('buy_info'));
    }
}

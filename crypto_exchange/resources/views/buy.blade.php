@extends('layouts.main')
@section('content')
    <nav class="navbar navbar-dark bg-dark">
        @csrf
        <form class="" method="GET" action="{{route("user.main")}}">
            <button class="btn btn-success" type="submit">Back</button>
        </form>
        <form class="pull-right" method="GET" action="{{route("user.logout")}}">
            <button class="btn btn-success" type="submit">Logout</button>
        </form>
    </nav>

    <form class=""  method="POST" action="{{route("user.buy")}}">
        @csrf
        <div class="form-group row">
            <label for="staticCoin" class="col-sm-2 col-form-label">Coin</label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control-plaintext" name='coin_name_to' id="staticCoin" value={{$buy_info->coin_name_to}}>
            </div>
        </div>

        <div class="form-group row">
            <label for="staticHaveCoin" class="col-sm-2 col-form-label">{{$buy_info->caption_amount_to}}</label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control-plaintext" id="staticHaveCoin" value={{$buy_info->amount_to}}>
            </div>
        </div>

        <div class="form-group row">
            <label for="staticBuyForCoin" class="col-sm-2 col-form-label">Buy for Coin</label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control" name='coin_name_from' id="staticBuyForCoin" value={{$buy_info->coin_name_from}}>
            </div>
        </div>

        <div class="form-group row">
            <label for="staticPriceCoin" class="col-sm-2 col-form-label">{{$buy_info->caption_price}}</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" name='price' id="staticPriceCoin" value={{$buy_info->price}}>
            </div>
        </div>


        <div class="form-group row">
            <label for="inputAmountCoin" class="col-sm-2 col-form-label">{{$buy_info->caption_amount_from}}</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="inputAmount" value={{$buy_info->amount_from}}>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputAmount" class="col-sm-2 col-form-label">How many coins do you want to buy</label>
            <div class="col-sm-10">
                <input type="number" step=any class="form-control" name='amount' id="inputAmount" placeholder="Enter amount">
            </div>
        </div>

        <button class="btn btn-success" type="submit">Buy</button>
      </form>

<script>
   let apiKey = "642808033f1312023cd887678a78c85f3a9b27af290241b567a772bb7f52d48d";
   let socket = new WebSocket("wss://streamer.cryptocompare.com/v2?api_key=" + apiKey);

    socket.onopen = function(e) {
        let money = document.getElementById('staticCoin').value;
        let subRequest;
        if (money == 'BTC'){
            subRequest = {
                "action": "SubAdd",
                "subs": ["0~Binance~BTC~USDT"]
            };
        } else {
            subRequest = {
                "action": "SubAdd",
                "subs": ["0~Binance~USDT~BTC"]
            };
        }
        socket.send(JSON.stringify(subRequest));
    };

    socket.onmessage = function(event) {
        const obj = JSON.parse(event.data);
        if (obj.TYPE == 0){
            document.getElementById('staticPriceCoin').value = obj.P;
        }
    };

    socket.onclose = function(event) {
    if (event.wasClean) {
        console.log(`[close] Соединение закрыто чисто, код=${event.code} причина=${event.reason}`);
    } else {
        console.log('[close] Соединение прервано');
    }
    };

    socket.onerror = function(error) {
        console.log(`[error]`);
    };  
</script>

@endsection


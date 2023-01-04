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

    <form>
        <div class="form-group row">
            <label for="staticCoin" class="col-sm-2 col-form-label">Coin</label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control-plaintext" id="staticCoin" value="BTC">
            </div>
        </div>

        <div class="form-group row">
            <label for="staticPriceCoin" class="col-sm-2 col-form-label">Price BTC</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control" id="staticPriceCoin" placeholder="16340.11">
            </div>
        </div>

        <div class="form-group row">
            <label for="staticBuyForCoin" class="col-sm-2 col-form-label">Buy for Coin</label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control-plaintext" id="staticBuyForCoin" value="USDT">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputAmountCoin" class="col-sm-2 col-form-label">Amount USDT</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control" id="inputAmount" placeholder="152.12">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputAmount" class="col-sm-2 col-form-label">How many coins do you want to buy BTC</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="inputAmount" placeholder="Enter amount">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
@endsection


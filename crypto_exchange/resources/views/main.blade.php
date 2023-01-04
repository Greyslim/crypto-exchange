@extends('layouts.main')
@section('content')
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        @csrf
        <form class="form-inline" method="GET" action="{{route("user.logout")}}">
          <button class="btn btn-success" type="submit">Logout</button>
        </form>
    </nav>
 
    <div>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Short name</th>
                <th scope="col">Amount</th>
                <th scope="col">Buy</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($user_coins as $user_coin)
                    <tr>
                        <th scope="row">{{$user_coin->id}}</th>
                        <td>{{$user_coin->name}}</td>
                        <td>{{$user_coin->short_name}}</td>
                        <td>{{$user_coin->amount}}</td>
                        <td>
                            <form class="" method="GET" action="{{route("user.buy")}}">
                                <button class="btn btn-success" type="submit" name="id" value={{$user_coin->id}}>Buy</button>
                            </form>   
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


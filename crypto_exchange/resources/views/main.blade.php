@extends('layouts.main')
@section('content')
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        @csrf
        <form class="form-inline" method="GET" action="{{route("user.logout")}}">
          <button class="btn btn-success" type="submit">Logout</button>
        </form>
    </nav>
 
    <div>
        @foreach ($users as $user)
            <form class="col-3 offset-4 border-4 border rounded" method="GET" action="{{route("user.buy")}}">
                <div>
                    {{$user->id}}
                    <button class="btn btn-lg btn-primary" type="submit" name="id" value={{$user->id}}>Buy</button>
                </div>
            </form>   
        @endforeach
    </div>
@endsection


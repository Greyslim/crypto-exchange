@extends('layouts.main')
@section('content')
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        @csrf
        <form class="form-inline" method="GET" action="{{route("user.logout")}}">
        <button class="btn btn-success" type="submit">Logout</button>
        </form>
    </nav>

    <h1>Buy</h1>
@endsection


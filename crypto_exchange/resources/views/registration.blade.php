@extends('layouts.main')
@section('content')
    <nav class="navbar navbar-dark bg-dark">
        @csrf
        <form class="pull-right" method="GET" action="{{route("user.login")}}">
            <button class="btn btn-success pull-right" type="submit">Back</button>
        </form>
    </nav>
    <form class="col-3 offset-4 border-4 border rounded" method="POST" action="{{route("user.registration")}}">
        @csrf
        <div class="form-group">
            <label for='name' class="col-form-label-lg">Name</label>
            <input class="form-control" id="name" name="name" type="text" value="" placeholder="Enter name">
            @error('name')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for='email' class="col-form-label-lg">Email</label>
            <input class="form-control" id="email" name="email" type="text" value="" placeholder="Enter email">
            @error('email')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for='password' class="col-form-label-lg">Password</label>
            <input class="form-control" id="password" name="password" type="password" value="" placeholder="Enter password">
            @error('password')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary" type="submit" name="sendMe" value="1">Registration</button>
        </div>
    </form>
@endsection
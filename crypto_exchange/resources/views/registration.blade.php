<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <title>Crypto-exchange</title>
</head>
<body>
<h1>Registration</h1>
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
        <input class="form-control" id="password" name="password" type="text" value="" placeholder="Enter password">
        @error('password')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
        <button class="btn btn-lg btn-primary" type="submit" name="sendMe" value="1">Registration</button>
    </div>
</form>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <title>Crypto-exchange</title>
</head>
<body>
<h1>Main</h1>
<form class="col-3 offset-4 border-4 border rounded" method="GET" action="{{route("user.logout")}}">
    @csrf
    <div class="form-group">
        <button class="btn btn-lg btn-primary" type="submit" name="sendMe" value="1">Logout</button>
    </div>
</form>
</body>
</html>
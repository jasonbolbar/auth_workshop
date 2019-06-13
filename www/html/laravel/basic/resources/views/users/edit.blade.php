@extends('layouts.app')
@section('content')
    <h1>Editing User</h1>

    <form action="/users/{{$user->id}}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Name:</label>
            <input type="text" name="name" value="{{$user->name}}">
        </div>
        <div>
            <label>Username:</label>
            <input type="text" name="email" value="{{$user->email}}">
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" value="{{$user->password}}">
        </div>
        <div>
            <input type="submit" name="Save">
        </div>

    </form>

    <a href="/users/{{$user->id}}">Show</a>
    <a href="/users">Back</a>

@endsection
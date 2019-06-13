@extends('layouts.app')
@section('content')
    <h1>New User</h1>

    <form action="/users" method="POST">
        @csrf
        <div>
            <label>Name:</label>
            <input type="text" name="name">
        </div>
        <div>
            <label>Username:</label>
            <input type="text" name="email">
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password">
        </div>
        <div>
            <input type="submit" name="Save">
        </div>

    </form>

    <a href="/users">Back</a>

@endsection
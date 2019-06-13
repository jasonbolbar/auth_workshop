@extends('layouts.app')
@section('content')
    <p id="notice">{{ $notice }}</p>

    <p>
        <strong>Name:</strong>
        {{ $user->name }}
    </p>

    <p>
      <strong>Username:</strong>
      {{ $user->email }}
    </p>

    <p>
      <strong>Password:</strong>
      ***Secret***
    </p>

    <a href="/users/{{$user->id}}/edit">Edit</a>
    <a href="/users">Back</a>

@endsection
@extends('layouts.app')
@section('content')
    <p id="notice">{{ $notice }}</p>
    <h1>Users</h1>
    
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Username</th>
          <th>Password</th>
          <th colspan="3"></th>
        </tr>
      </thead>
    
      <tbody>
      <script type="text/javascript">
          function submitform(e) {   e.parentElement.submit(); }
      </script>
      @foreach($users as $user)
          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>***Secret***</td>
            <td><a href="/users/{{$user->id}}">Show</a></td>
            <td><a href="/users/{{$user->id}}/edit">Edit</a></td>
            <td><form id="deleteForm" action="{{ URL::route('users.destroy', $user->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <a href="javascript:void" onclick="submitform(this)">Delete</a>
                </form></td>
          </tr>
        @endforeach
      </tbody>
    </table>
    
    <br>

    <a href="/users/create">New User</a>
    
@endsection

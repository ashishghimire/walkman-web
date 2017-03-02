@extends('layouts.app')

@section('content')
<div class="container">
 <h3>Sponsors</h3>
<ul class="list-group">
 @forelse($users as $user)
   <li class="list-group-item">{{$user->name}}
   <a href="{{route('user.edit',$user->id)}}"><button type="button" class="btn btn-default">Edit</button></a>
   <button type="button" class="btn btn-info">Impersonate</button>
   <a href="{{route('user.change-password',$user->id)}}"><button type="button" class="btn btn-success">Change Password</button></a>
      <button type="button" class="btn btn-danger">Delete</button>
   </li>
  @empty
  There are no sponsors yet
  @endforelse
</ul>
</div>
@endsection
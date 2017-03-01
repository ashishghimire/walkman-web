@extends('layouts.app')

@section('content')
<div class="container">
 <h3>Sponsors</h3>
<ul class="list-group">
 @forelse($users as $user)
   <li class="list-group-item">{{$user->name}}
   <a href="{{route('user.edit',$user->id)}}"><button type="button" class="btn btn-default">Edit</button></a>
   <button type="button" class="btn btn-info">Impersonate</button>
   <button type="button" class="btn btn-danger">Delete</button>
   </li>
  @empty
  There are no sponsors yet
  @endforelse
</ul>
</div>
@endsection
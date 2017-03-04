@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}">Home</a></li>
        <li class="active">Sponsors</li>
    </ol>
    <div class="container">
        <h3>Sponsors</h3>
        <ul class="list-group">
            @forelse($users as $user)
                <li class="list-group-item"><a href="{{route('user.show', $user->id)}}">{{$user->name}}</a>
                    <a href="{{route('user.edit',$user->id)}}">
                        <button type="button" class="btn btn-default">Edit</button>
                    </a>

                    <a href="{{route('user.masquerade',$user->id)}}">
                        <button type="button" class="btn btn-info">Impersonate</button>
                    </a>
                    <a href="{{route('user.change-password',$user->id)}}">
                        <button type="button" class="btn btn-success">Change Password</button>
                    </a>
                    {!! Form::open(['route'=>['user.destroy', $user->id], 'method' => 'DELETE',  'onsubmit' => 'return confirmDelete()']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </li>
            @empty
                There are no sponsors yet
            @endforelse
        </ul>
        <a href="{{route('register')}}">
            <button type="button" class="btn btn-default">Add new sponsor</button>
        </a>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{$user->name}}</h3>
        <ul class="list-group">
            @forelse($user->incentives as $incentive)
                <li class="list-group-item">{{$incentive->description}}

                    <button type="button" class="btn btn-danger">Delete</button>
                </li>
            @empty
                There are no incentives currently
            @endforelse
        </ul>
        @if(auth()->user()->isAdmin())
            <a href="{{route('user.incentive.create',$user->id)}}">
                <button type="button" class="btn btn-default">Add New Incentive</button>
            </a>
        @endif
    </div>
@stop
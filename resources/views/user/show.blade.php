@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}">Home</a></li>
        @if(auth()->user()->isAdmin())
            <li><a href="{{route('user.index')}}">Sponsors</a></li>
        @endif
        <li class="active">{{auth()->user()->isAdmin() ? $user->name : 'Profile'}}</li>
    </ol>
    <div class="container">
        <h3>{{$user->name}}</h3>
        @if(auth()->user()->isAdmin())
            <h6><a href="{{route('user.masquerade',$user->id)}}">
                    Impersonate
                </a></h6>
        @endif
        <div class="clearfix"></div>
        <ul class="list-group">
            <h4>Incentives</h4>
            {{--            {{dd($user->incentives)}}--}}
            @forelse($user->incentives as $incentive)
                <li class="list-group-item">
                    <a href="#" data-toggle="modal"
                       data-target="#myModal">{{$incentive->description}}
                    </a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{route('user.incentive.edit', [$user->id, $incentive->id])}}">
                            <button type="button" class="btn btn-default">Edit</button>
                        </a>
                        {!! Form::open(['route'=>['user.incentive.destroy', $user->id, $incentive->id], 'method' => 'DELETE',  'onsubmit' => 'return confirmDelete()']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    @endif

                </li>
                @include('partials.incentive-description', ['incentive' => $incentive])
            @empty
                There are no incentives currently
            @endforelse
        </ul>
        @if(auth()->user()->isAdmin())
            <a href="{{route('user.incentive.create',$user->id)}}">
                <button type="button" class="btn btn-default">Add New Incentive</button>
            </a>
        @endif
        @include('partials.gifts-table')
    </div>
@stop
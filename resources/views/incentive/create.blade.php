@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}">Home</a></li>
        <li><a href="{{route('user.index')}}">Sponsors</a></li>
        <li><a href="{{route('user.show', $user->id)}}">{{$user->name}}</a></li>
        <li class="active">Add Incentive</li>
    </ol>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add Incentive by {{$user->name}}</div>
                    <div class="panel-body">
                        {!!Form::open(['route' => ['user.incentive.store', $user->id], 'files'=> true, 'class'=>'form-horizontal'])!!}

                        @include('partials.incentive-form', ['create'=>true])

                        {!!Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
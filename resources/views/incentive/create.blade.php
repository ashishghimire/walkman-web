@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add Incentives by {{$user->name}}</div>
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
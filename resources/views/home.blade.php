@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="active">Home</li>
    </ol>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item"><a href="{{route('user.index')}}">View Sponsors</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">{{$incentive->description}}</h4>
                            </div>
                            <div class="modal-body">
                                <p>Distribution day: {{ucfirst($incentive->day)}}</p>

                                @if(!empty($incentive->photo))
                                    <p>
                                        <img src="{{url($incentive->photo)}}" height="300" width="400">
                                    </p>
                                @endif

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
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
@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}">Home</a></li>
        <li><a href="{{route('user.index')}}">Sponsors</a></li>
        <li><a href="{{route('user.show', $user->id)}}">{{$user->name}}</a></li>
        <li class="active">Edit Profile</li>
    </ol>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Sponsor</div>
                    <div class="panel-body">
                        {!!Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'PATCH', 'files'=> true, 'class'=>'form-horizontal'])!!}


                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                {!!Form::text('name', null, ['class'=>'form-control', 'required'])!!}

                                @if ($errors->has('name'))
                                    <span class="help-block">
	                                        <strong>{{ $errors->first('name') }}</strong>
	                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                {!!Form::email('email', null, ['class'=>'form-control', 'required'])!!}

                                @if ($errors->has('email'))
                                    <span class="help-block">
	                                        <strong>{{ $errors->first('email') }}</strong>
	                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                            <label for="photo" class="col-md-4 control-label">Photo</label>
                            <div class="col-md-6">
                                @if(!empty($user->photo))
                                    <div id="image-wrap">
                                        <img src="{{url($user->photo)}}" height="300" width="400">
                                        <div id="remove-image">X</div>
                                    </div>
                                @else
                                    {!!Form::file('photo',['class'=>'form-control', 'id'=>'photo', 'accept'=>'image/*'])!!}
                                @endif
                                <div class="{{empty(old('photo'))? 'hidden' : ''}} remove">X</div>
                                @if ($errors->has('photo'))
                                    <span class="help-block">
	                                        <strong>{{ $errors->first('photo') }}</strong>
	                                        </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!!Form::submit('Submit')!!}
                            </div>
                        </div>


                        {!!Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
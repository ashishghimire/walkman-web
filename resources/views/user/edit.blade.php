@extends('layouts.app')

@section('content')
	<div class="container">
    	<div class="row">
        	<div class="col-md-8 col-md-offset-2">
            	<div class="panel panel-default">
                	<div class="panel-heading">Edit Sponsor</div>
                	<div class="panel-body">
						{!!Form::model($user, ['route' => ['user.update', $user->id], 'files'=> true])!!}
							

							<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	                            <label for="name" class="col-md-4 control-label">Name</label>

	                            <div class="col-md-6">
	                                {!!Form::text('name', null, ['class'=>'form-control'])!!}

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
	                            	{!!Form::email('email', null, ['class'=>'form-control'])!!}

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
	                                    {!!Form::file('photo',['class'=>'form-control', 'id'=>'photo', 'accept'=>'image/*'])!!}
	                                    @if(!empty($user->photo))
	                                    	<img src="{{storage_path('app/'.$user->photo)}}">
	                                    @endif
	                                    <!-- <input type="file" id = "photo" class="form-control" name="photo" value="{{ old('photo') }} " accept="image/*"> -->
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
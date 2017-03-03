@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add Incentives by {{$user->name}}</div>
                    <div class="panel-body">
                        {!!Form::open(['route' => ['user.incentive.create', $user], 'files'=> true, 'class'=>'form-horizontal'])!!}

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                {!!Form::text('description', null, ['class'=>'form-control', 'required'])!!}

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
	                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('day') ? ' has-error' : '' }}">
                            <label for="day" class="col-md-4 control-label">Distribution Day</label>

                            <div class="col-md-6">
                                {!!Form::select('day', config('constants.days'), 'sunday', ['class'=>'form-control', 'required'])!!}

                                @if ($errors->has('day'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('day') }}</strong>
	                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('gold_value') ? ' has-error' : '' }}">
                            <label for="gold_value" class="col-md-4 control-label">Value (In golds)</label>

                            <div class="col-md-6">
                                {!!Form::number('gold_value', 0, ['class'=>'form-control', 'required'])!!}

                                @if ($errors->has('gold_value'))
                                    <span class="help-block">
	                                        <strong>{{ $errors->first('gold_value') }}</strong>
	                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                            <label for="photo" class="col-md-4 control-label">Photo</label>
                            <div class="col-md-6">
                            {!!Form::file('photo',['class'=>'form-control', 'id'=>'photo', 'accept'=>'image/*'])!!}

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
@stop
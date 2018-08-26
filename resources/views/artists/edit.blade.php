@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row ">
      <div class="col-md-12">
        <div class="card ">
          <div class="card-header bg-dark text-white">Edit an Artist</div>

          <div class="card-body">
            {!! Form::open(['method' => 'POST', 'action' => ['ArtistController@update', $artist->id], 'class' => 'form-horizontal']) !!}
            <div class="row">

              <div class="col-md-6">
                <div class="form-group{{ $errors->has('stage_name') ? ' has-error' : '' }}">
                    {!! Form::label('stage_name', 'Stage name of the Artist') !!}
                    {!! Form::text('stage_name', $artist->stage_name, ['class' => 'form-control', 'required' => 'required', 'disabled']) !!}
                    <small class="text-danger">{{ $errors->first('stage_name') }}</small>
                </div>
              </div>


              <div class="col-md-6">
                <div class="form-group{{ $errors->has('real_name') ? ' has-error' : '' }}">
                    {!! Form::label('real_name', 'Real name of the Artist') !!}
                    {!! Form::text('real_name', $artist->real_name, ['class' => 'form-control', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('real_name') }}</small>
                </div>
              </div>



            </div>

          <div class="form-group{{ $errors->has('bio' ) ? ' has-error' : '' }}">
              {!! Form::label('bio' , 'Artist bio') !!}
              {!! Form::textarea('bio'  , $artist->bio, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('bio'  ) }}</small>
          </div>


            <div class="btn-group pull-right">
              {!! Form::submit("Update artist", ['class' => 'btn btn-success']) !!}
            </div>
            {!! Form::close() !!}


          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

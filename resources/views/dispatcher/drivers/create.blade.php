@extends('layout')

@section('content')
    <div class="jumbotron">
        <h1>Create driver</h1>
        {!! Form::open() !!}
        <div class="form-group">
            {!! Form::label('name','Name') !!}
            {!! Form::text('name', null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('city','City') !!}
            {!! Form::text('city', null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('email','Email') !!}
            {!! Form::text('email',null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password','Password') !!}
            {!! Form::password('password', ['class'=>'form-control']) !!}
        </div>
        {!! Form::submit('Add',['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection

@section('js')
@endsection
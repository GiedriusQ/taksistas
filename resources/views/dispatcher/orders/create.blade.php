@extends('layout')

@section('content')
    <div class="jumbotron">
        <h1>Create order</h1>
        {!! Form::open() !!}
        <div class="form-group">
            {!! Form::label('client','Client') !!}
            {!! Form::text('client', null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('from','Take from') !!}
            {!! Form::text('from',null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('to','Transport to') !!}
            {!! Form::text('to',null, ['class'=>'form-control']) !!}
        </div>
        {!! Form::submit('Add',['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection

@section('js')
@endsection
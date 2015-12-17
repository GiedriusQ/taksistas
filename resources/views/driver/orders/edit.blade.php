@extends('layout')

@section('content')
    <div class="jumbotron">
        <h1>Edit order</h1>
        {!! Form::model($order) !!}
        <div class="form-group">
            {!! Form::label('client','Client') !!}
            {!! Form::text('client', null,['class'=>'form-control','disabled']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('from','Take from') !!}
            {!! Form::text('from',null, ['class'=>'form-control','disabled']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('to','Transport to') !!}
            {!! Form::text('to',null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('status','Status') !!}
            {!! Form::select('status',config('statuses'),null, ['class'=>'form-control']) !!}
        </div>

        {!! Form::submit('Update',['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection

@section('js')
@endsection
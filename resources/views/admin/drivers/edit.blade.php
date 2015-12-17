@extends('layout')

@section('content')
    <div class="jumbotron">
        <h1>Edit driver</h1>
        {!! Form::model($driver->data) !!}
        @include('admin.admins.form')
        {!! Form::submit('Update',['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection

@section('js')
@endsection
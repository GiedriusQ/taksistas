@extends('layout')

@section('content')
    <div class="jumbotron">
        <h1>Edit dispatcher</h1>
        {!! Form::model($dispatcher->data) !!}
        @include('admin.admins.form')
        {!! Form::submit('Update',['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection

@section('js')
@endsection
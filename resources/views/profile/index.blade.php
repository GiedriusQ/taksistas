@extends('layout')

@section('content')
    <div class="jumbotron">
        Logged in as {{$user->name}}
    </div>
@endsection

@section('js')
@endsection
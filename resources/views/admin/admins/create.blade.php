@extends('layout')

@section('content')
    <div class="jumbotron">
        @include('admin.partials.create',['name'=>'Administrator'])
    </div>
@endsection

@section('js')
@endsection
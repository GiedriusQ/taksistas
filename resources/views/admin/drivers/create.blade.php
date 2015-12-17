@extends('layout')

@section('content')
    <div class="jumbotron">
        @include('admin.partials.create',['name'=>'Driver', 'dispatchers_list'=>$dispatchers_list])
    </div>
@endsection

@section('js')
@endsection
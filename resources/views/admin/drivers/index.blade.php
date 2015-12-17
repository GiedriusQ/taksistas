@extends('layout')

@section('content')
    <div class="jumbotron">
        @include('admin.partials.users',['items'=>$drivers,'name'=>'Driver','resource_name'=>'Drivers'])
    </div>
@endsection

@section('js')
@endsection
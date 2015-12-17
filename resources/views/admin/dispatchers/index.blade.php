@extends('layout')

@section('content')
    <div class="jumbotron">
        @include('admin.partials.users',['items'=>$dispatchers,'name'=>'Dispatcher','resource_name'=>'Dispatchers'])
    </div>
@endsection

@section('js')
@endsection
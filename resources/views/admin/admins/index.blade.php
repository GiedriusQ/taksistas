@extends('layout')

@section('content')
    <div class="jumbotron">
        @include('admin.partials.users',['items'=>$admins,'name'=>'Admin','resource_name'=>'Administrators'])
    </div>
@endsection

@section('js')
@endsection
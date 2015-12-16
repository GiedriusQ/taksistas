@extends('layout')

@section('content')
    <div class="jumbotron">
        <form method="POST" action="{{action('Front\LoginController@postLogin')}}">
            {!! csrf_field() !!}

            <div class="form-group">
                Email
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                Password
                <input type="password" class="form-control" name="password" id="password">
            </div>

            <div class="form-group">
                <input type="checkbox" name="remember"> Remember Me
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Login</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
@endsection
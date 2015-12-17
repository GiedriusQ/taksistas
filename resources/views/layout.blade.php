<!DOCTYPE html>
<html>
<head>
    <title>TAXI</title>
    <link href="{{asset('css/libs.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
@if(session('user'))
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">TMS</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                @if(session('user.type') == 0)
                    @include('admin.partials.navbar')
                @endif
                @if(session('user.type') == 1)
                    @include('dispatcher.partials.navbar')
                @endif
                @if(session('user.type') == 2)
                    @include('driver.partials.navbar')
                @endif
                <ul class="nav navbar-nav pull-right">
                    <li class="navbar-text"><span class="glyphicon glyphicon-user"></span> {{$user->name}}</li>
                    <li><a href="{{action('Front\LoginController@getLogout')}}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
@endif
<div class="container">
    @include('partials.errors')
    @yield('content')
</div>

<script type="text/javascript" src="{{asset('js/libs.js')}}"></script>
<script type="text/javascript" src="{{asset('js/main.js')}}"></script>
@yield('js')
</body>
</html>

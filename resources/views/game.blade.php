<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkers</title>
    <link href="{{asset('css/libs.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h1>Checkers</h1>

        <div id="log-in-box">
            <h3>Start the game by typing</h3>

            <div class="form-group">
                <label for="nick">Your nickname (to register new user)</label>
                <input class="form-control" id="nick" name="nick"/>
            </div>
            <div class="form-group">
                <label for="key">or Secret Key (to login into Your old user)</label>
                <input class="form-control" id="key" name="key"/>
            </div>
            <button type="button" class="btn btn-success btn-lg" id="log-in">Log in!</button>
        </div>
        <div id="register-box" style="display:none;">
            <h3>Successfully registered</h3>

            <div>Your key: <strong data-key></strong></div>
            <button type="button" class="btn btn-success btn-lg" id="continue">Continue</button>
        </div>
        <div id="games-box" style="display:none;">
            <h3>Logged in as <span data-name></span></h3>

            <div>
                <p>My rooms:</p>
                <ul class="list" id="games-list-my" data-game></ul>
            </div>
            <div>
                <p>Playing in:</p>
                <ul class="list" id="games-list-playing" data-game></ul>
            </div>
            <div>
                <p>Available rooms:</p>
                <ul class="list" id="games-list-other" data-game></ul>
            </div>
            <button type="button" class="btn btn-success btn-lg" id="refresh">Refresh</button>
            <button type="button" class="btn btn-success btn-lg" id="create-new-game">Create new game</button>
            <button type="button" class="btn btn-success btn-lg" id="logout">Logout</button>
        </div>
        <div id="game-box" style="display:none;">
            <h3>Logged in as <span data-name></span></h3>

            <div><p>Game - <span data-game-title></span></p></div>
            <div>
                <canvas id="checkers" width="320" height="360"></canvas>
            </div>
            <button type="button" class="btn btn-success btn-lg" id="go-to-list">Exit to games list</button>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{asset('js/libs.js')}}"></script>
<script type="text/javascript" src="{{asset('js/main.js')}}"></script>
</body>
</html>

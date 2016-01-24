var url = {
    register: 'api/register',
    login   : 'api/login',
    games   : 'api/games'
};
var api_key, game_id, in_game = false;

function hideAll() {
    in_game = false;
    $('div.jumbotron > div').hide();
}
function registerUsingNick(nick) {
    $.ajax({
        type    : "POST",
        url     : url.register,
        data    : {nick: nick},
        success : function (data) {
            $('[data-name]').html(nick);
            api_key = data.data.api_key;
            $('[data-key]').html(data.data.api_key);
            hideAll();
            $('#register-box').show();
        },
        error   : function (data) {
            swal('Validation error', data.responseJSON.error.nick, "error");
        },
        dataType: 'json'
    });
}
function loginUsingKey(key) {
    $.ajax({
        type    : "POST",
        url     : url.login,
        data    : {api_key: key},
        success : function (data) {
            $('[data-name]').html(data.data.nick);
            api_key = key;
            $('[data-key]').html(key);
            $('#continue').click();
        },
        error   : function (data) {
            swal('Validation error', data.responseJSON.error.api_key, "error");
        },
        dataType: 'json'
    });
}
$('#log-in').click(function () {
    var nick = $('#nick').val();
    var key = $('#key').val();
    if (nick != '' && key == '') {
        registerUsingNick(nick);
    }
    if (key != '' && nick == '') {
        loginUsingKey(key);
    }
});
function loadGames() {
    $.ajax({
        type    : "GET",
        data    : {api_key: api_key},
        url     : url.games,
        success : function (data) {
            hideAll();
            $('#games-box').show();
            var $games_my = $('#games-list-my');
            var $games_playing = $('#games-list-playing');
            var $games_other = $('#games-list-other');
            $games_my.html('');
            $games_playing.html('');
            $games_other.html('');
            if (data.data.games_my.length == 0) {
                $games_my.append('<li>No games available</li>');
            }
            else {
                $.each(data.data.games_my, function (key, game) {
                    $games_my.append('<li class="list-group-item pointer" data-game-id="' + key + '">' + game + '</li>');
                });
            }
            if (data.data.games_playing.length == 0) {
                $games_playing.append('<li>No games available</li>');
            }
            else {
                $.each(data.data.games_playing, function (key, game) {
                    $games_playing.append('<li class="list-group-item pointer" data-game-id="' + key + '">' + game + '</li>');
                });
            }
            if (data.data.games_other.length == 0) {
                $games_other.append('<li>No games available</li>');
            }
            else {
                $.each(data.data.games_other, function (key, game) {
                    $games_other.append('<li class="list-group-item pointer" data-game-id="' + key + '">' + game + '</li>');
                });
            }
        },
        dataType: 'json'
    });
}
$('#continue, #go-to-list, #refresh').click(function () {
    loadGames();
});

function createGame(game_title) {
    $.ajax({
        type    : "POST",
        data    : {title: game_title, api_key: api_key},
        url     : url.games,
        success : function (data) {
            game_id = data.data.id;
            hideAll();
            in_game = true;
            $('[data-game-title]').html(data.data.game);
            $('#game-box').show();
            NewGame(data.data.board, data.data.red, data.data.black, data.data.my_turn, data.data.red_turn);
        },
        dataType: 'json'
    });
}
$('#create-new-game').click(function () {
    swal({
            title           : "Create new game",
            text : "Type in game title:",
            type : "input",
            showCancelButton: true,
            closeOnConfirm  : false,
            animation       : "slide-from-top",
            inputPlaceholder: "Game title"
        },
        function (game_title) {
            if (game_title === false) return false;

            if (game_title === "") {
                swal.showInputError("Game title is required!");
                return false
            }
            swal.close();
            createGame(game_title);
        });
});

$('#logout').click(function () {
    hideAll();
    $('#log-in-box').show();
});

function getBoard() {
    $.ajax({
        type    : "GET",
        data    : {api_key: api_key},
        url     : url.games + '/' + game_id,
        success : function (data) {
            hideAll();
            in_game = true;
            $('[data-game-title]').html(data.data.game);
            $('#game-box').show();
            NewGame(data.data.board, data.data.red, data.data.black, data.data.my_turn, data.data.red_turn);
        },
        dataType: 'json'
    });
}
$('body').on('click', '[data-game-id]', function () {
    game_id = $(this).data('game-id');
    getBoard();
});

setInterval(function () {
    if (in_game && !myy_turn) {
        getBoard();
    }
}, 1000);

function doMove(move) {
    $.ajax({
        type    : "POST",
        url     : url.games + '/' + game_id,
        data    : {api_key: api_key, move: move},
        success : function (data) {
            in_game = true;
            NewGame(data.data.board, data.data.red, data.data.black, data.data.my_turn, data.data.red_turn);
        },
        error   : function (data) {
            swal('Forbidden', data.responseJSON.error.message, "error");
        },
        dataType: 'json'
    });
}
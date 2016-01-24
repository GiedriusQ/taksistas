<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests\CreateGameRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Liustr\Json\JsonRespond;
use App\Session;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * @var JsonRespond
     */
    protected $jsonRespond;
    /**
     * @var Session|null $session
     */
    protected $session = null;

    public function __construct(Request $request, JsonRespond $jsonRespond)
    {
        if ($request->has('api_key')) {
            $this->session = Session::whereKey($request->input('api_key'))->first();
        }
        $this->jsonRespond = $jsonRespond;
    }

    public function postLogin(LoginRequest $request)
    {
        return $this->jsonRespond->setStatusCode(200)->respondWithData(['nick' => $this->session->nick]);
    }

    public function postRegister(RegistrationRequest $request, Session $session)
    {
        $session = $session->create($request->all());

        return $this->jsonRespond->setStatusCode(200)->respondWithData(['api_key' => $session->key]);
    }

    public function getGames(Game $game)
    {
        $my_games = $this->session->createdGames->lists('title', 'id');

        $playing_in = $this->session->otherGames->lists('title', 'id');

        $other_games = $game->notStarted()->notUser($this->session)->get()->lists('title', 'id');

        return $this->jsonRespond->setStatusCode(200)->respondWithData([
            'games_my'      => $my_games,
            'games_playing' => $playing_in,
            'games_other'   => $other_games
        ]);
    }

    public function postGame(CreateGameRequest $request)
    {
        $game = $this->session->createdGames()->create($request->all());

        return $this->jsonRespond->setStatusCode(200)->respondWithData($this->gameData($game));
    }

    public function getGame(Game $game)
    {
        if ($this->session != $game->owner) {
            $game->opponent()->associate($this->session);
            $game->save();
        }

        return $this->jsonRespond->setStatusCode(200)->respondWithData($this->gameData($game));
    }

    public function postMove(Request $request, Game $game)
    {
        if (!$game->isMyTurn($this->session)) {
            return $this->jsonRespond->setStatusCode(403)->respondWithError('Not Your Turn');
        }
        list($x, $y, $to_x, $to_y) = $this->xy($request);
        $board = $game->board;
        $move  = $to_x . '-' . $to_y;

        list($available, $board) = $this->getAvalaibleMoves($board, $x, $y, $to_y, $to_x);

        if (!in_array($move, $available)) {
            return $this->jsonRespond->setStatusCode(403)->respondWithError('Bad Move');
        }

        $color               = $board[$x][$y];
        $board[$x][$y]       = 0;
        $board[$to_x][$to_y] = $color;

        $game->board      = $board;
        $game->owner_turn = !$game->owner_turn;
        $game->save();

        return $this->jsonRespond->setStatusCode(200)->respondWithData($this->gameData($game));
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function xy(Request $request)
    {
        $x    = $request->input('move.0.0');
        $y    = $request->input('move.0.1');
        $to_x = $request->input('move.1.0');
        $to_y = $request->input('move.1.1');

        return [$x, $y, $to_x, $to_y];
    }

    /**
     * @param $board
     * @param $x
     * @param $y
     * @param $to_y
     * @param $to_x
     * @return array
     */
    protected function getAvalaibleMoves($board, $x, $y, $to_y, $to_x)
    {
        $available = [];
        //playing with reds
        if ($board[$x][$y] == '1') {
            if ($x - 1 >= 0 && $y + 1 <= 7) {
                if ($board[$x - 1][$y + 1] == '0') {
                    $available[] = ($x - 1) . '-' . ($y + 1);
                }
            }
            if ($x + 1 <= 7 && $y + 1 <= 7) {
                if ($board[$x + 1][$y + 1] == '0') {
                    $available[] = ($x + 1) . '-' . ($y + 1);
                }
            }
            if ($x - 2 >= 0 && $y + 2 <= 7) {
                if ($board[$x - 1][$y + 1] == '-1' && $board[$x - 2][$y + 2] == '0') {
                    $available[] = ($x - 2) . '-' . ($y + 2);
                }
            }
            if ($x + 2 <= 7 && $y + 2 <= 7) {
                if ($board[$x + 1][$y + 1] == '-1' && $board[$x + 2][$y + 2] == '0') {
                    $available[] = ($x + 2) . '-' . ($y + 2);
                }
            }
            if (abs($to_y - $y) > 1) {
                //capturing
                $board[$x > $to_x ? $x - 1 : $x + 1][$to_y - 1] = 0;
            }
        }

        //playing with blacks
        if ($board[$x][$y] == '-1') {
            if ($x - 1 >= 0 && $y - 1 >= 0) {
                if ($board[$x - 1][$y - 1] == '0') {
                    $available[] = ($x - 1) . '-' . ($y - 1);
                }
            }
            if ($x + 1 <= 7 && $y - 1 >= 0) {
                if ($board[$x + 1][$y - 1] == '0') {
                    $available[] = ($x + 1) . '-' . ($y - 1);
                }
            }
            if ($x - 2 >= 0 && $y - 2 >= 0) {
                if ($board[$x - 1][$y - 1] == '1' && $board[$x - 2][$y - 2] == '0') {
                    $available[] = ($x - 2) . '-' . ($y - 2);
                }
            }
            if ($x + 2 <= 7 && $y - 2 >= 0) {
                if ($board[$x + 1][$y - 1] == '1' && $board[$x + 2][$y - 2] == '0') {
                    $available[] = ($x + 2) . '-' . ($y - 2);
                }
            }
            if (abs($to_y - $y) > 1) {
                //capturing
                $board[$x > $to_x ? $x - 1 : $x + 1][$y - 1] = 0;
            }
        }

        return [$available, $board];
    }

    /**
     * @param $game
     * @return array
     */
    protected function gameData($game)
    {
        return [
            'id'       => $game->id,
            'game'     => $game->title,
            'board'    => $game->board,
            'red'      => $game->red_count,
            'black'    => $game->black_count,
            'my_turn'  => $game->isMyTurn($this->session),
            'red_turn' => !$game->owner_turn,
        ];
    }

}
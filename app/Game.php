<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $dates = ['started_at'];
    protected $casts = ['board' => 'json'];
    protected $fillable = ['title', 'end', 'owner_turn'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Game $game) {
            $game->board = [
                [0, 1, 0, 0, 0, -1, 0, -1],
                [1, 0, 1, 0, 0, 0, -1, 0],
                [0, 1, 0, 0, 0, -1, 0, -1],
                [1, 0, 1, 0, 0, 0, -1, 0],
                [0, 1, 0, 0, 0, -1, 0, -1],
                [1, 0, 1, 0, 0, 0, -1, 0],
                [0, 1, 0, 0, 0, -1, 0, -1],
                [1, 0, 1, 0, 0, 0, -1, 0],
            ];
        });
    }

    public function owner()
    {
        return $this->belongsTo(Session::class, 'owner_id');
    }

    public function opponent()
    {
        return $this->belongsTo(Session::class, 'opponent_id');
    }

    public function scopeNotStarted($query)
    {
        $query->whereNull('opponent_id');
    }

    public function scopeNotUser($query, $session)
    {
        if ($session instanceof Session) {
            $session = $session->id;
        }
        $query->where('owner_id', '!=', $session);
    }

    public function getTitleAttribute($title)
    {
        return $title . ': ' . $this->owner->nick . ' VS ' . (!$this->opponent ? '-' : $this->opponent->nick);
    }

    public function getRedCountAttribute()
    {
        $cnt = 0;
        foreach ($this->board as $line) {
            foreach ($line as $column) {
                if ($column == 1) {
                    $cnt++;
                }
            }
        }

        return $cnt;
    }

    public function getBlackCountAttribute()
    {
        $cnt = 0;
        foreach ($this->board as $line) {
            foreach ($line as $column) {
                if ($column == -1) {
                    $cnt++;
                }
            }
        }

        return $cnt;
    }

    public function isMyTurn(Session $session)
    {
        return ($this->owner_turn && $this->owner == $session) || (!$this->owner_turn && $this->opponent == $session);
    }

    public function playerTurn()
    {
    }

}

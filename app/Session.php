<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Session $session) {
            $session->key = str_random(30);
        });
    }

    protected $fillable = ['nick', 'key'];

    public function createdGames()
    {
        return $this->hasMany(Game::class, 'owner_id');
    }

    public function otherGames()
    {
        return $this->hasMany(Game::class, 'opponent_id');
    }
}

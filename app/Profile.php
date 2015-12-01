<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Profile
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $city
 * @method static \Illuminate\Database\Query\Builder|\App\Profile whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Profile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Profile whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Profile whereCity($value)
 * @property-read \App\User $user
 */
class Profile extends Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * App\User
 *
 * @property integer $id
 * @property integer $parent_id
 * @property boolean $type
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property-read \App\User $parent
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDeletedAt($value)
 * @property-read \App\User $dispatcher
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $drivers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DriverLocation[] $locations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\StatsHistory[] $statuses
 * @property-read \App\Profile $profile
 */
class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['password', 'email', 'type', 'name', 'city'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'id'];

    public $timestamps = false;

    public function dispatcher()
    {
        return $this->belongsTo('App\User', 'parent_id');
    }

    public function drivers()
    {
        return $this->hasMany('App\User', 'parent_id');
    }

    public function orders()
    {
        return $this->type == 1 ? $this->hasMany('App\Order', 'dispatcher_id') : $this->hasMany('App\Order',
            'driver_id');
    }

    public function locations()
    {
        return $this->hasMany('App\DriverLocation', 'driver_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany('App\StatusHistory');
    }

    public function isAdmin()
    {
        return $this->type == 0;
    }

    public function owns($id)
    {
        return $this->drivers()->whereId($id)->exists() || $this->dispatcher()->whereId($id)->exists() || $this->isAdmin() || $this->id == $id;
    }
}

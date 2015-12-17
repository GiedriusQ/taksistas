<?php

namespace App;

use App\GK\Utilities\Bing;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Hash;

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
 * @property string $name
 * @property string $city
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User admin()
 * @method static \Illuminate\Database\Query\Builder|\App\User dispatcher()
 * @method static \Illuminate\Database\Query\Builder|\App\User driver()
 * @property-read mixed $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\StatusHistory[] $statuses
 * @method static \Illuminate\Database\Query\Builder|\App\User isAdmin()
 * @method static \Illuminate\Database\Query\Builder|\App\User isDispatcher()
 * @method static \Illuminate\Database\Query\Builder|\App\User isDriver()
 */
class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes;

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
    protected $fillable = ['password', 'email', 'name', 'city'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['role'];

    protected $casts = ['id' => 'int', 'type' => 'int'];

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
        return $this->hasMany('App\DriverLocation', 'driver_id')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany('App\StatusHistory');
    }

    public function is_admin()
    {
        return $this->type == 0;
    }

    public function is_dispatcher()
    {
        return $this->type == 1;
    }

    public function is_driver()
    {
        return $this->type == 2;
    }

    public function owns($id)
    {
        return $id == null || $this->drivers()->whereId($id)->exists() || $this->dispatcher()->whereId($id)->exists() || $this->is_admin() || $this->id == $id;
    }

    public function ownsOrder($order)
    {
        $id = $order instanceof Model ? $order->id : $order;

        return $id == null || $this->orders()->whereId($id)->whereDriverId($this->id)->exists() || $this->orders()->whereId($id)->whereDispatcherId($this->id)->exists();
    }

    public function scopeIsAdmin($query)
    {
        $query->whereType('0');
    }

    public function scopeIsDispatcher($query)
    {
        $query->whereType('1');
    }

    public function scopeIsDriver($query)
    {
        $query->whereType('2');
    }

    public function getRoleAttribute()
    {
        return $this->attributes['type'] == 0 ? 'administrator' : ($this->attributes['type'] == 1 ? 'dispatcher' : 'driver');
    }

    public function setPasswordAttribute($value)
    {
        if (strlen($value) < 3) {
            return;
        }
        $this->attributes['password'] = Hash::needsRehash($value) ? bcrypt($value) : $value;
    }

    public function createAdmin(array $attributes = [])
    {
        return $this->createUserWithType($attributes, 0);
    }

    public function createDispatcher(array $attributes = [])
    {
        return $this->createUserWithType($attributes, 1);
    }

    public function createDriverForDispatcher(array $attributes = [])
    {
        return $this->drivers()->save($this->makeUserWithType($attributes, 2));
    }

    private function makeUserWithType(array $attributes, $type)
    {
        $user       = new User($attributes);
        $user->type = $type;

        return $user;
    }

    private function createUserWithType(array $attributes, $type)
    {
        $user       = new User($attributes);
        $user->type = $type;
        $user->save();

        return $user;
    }

    public function createOrder(array $attributes = [])
    {
        return $this->orders()->create($attributes);
    }

    public function assignNearestOrderIfAvailable()
    {
        if (!$this->is_driver()) {
            return;
        }
        if ($this->orders()->where('status', '!=', '2')->count() > 0) {
            return;
        }
        $orders    = $this->dispatcher->orders()->whereStatus(0)->whereDriverId(null)->get();
        $min_order = 0;
        $min_dist  = 0;
        if (count($orders) == 0 || !$this->locations()->exists()) {
            return;
        }
        foreach ($orders as $order) {
            $dist = Bing::distanceBetweenTwoPoints($this->locations[0]->lat,
                $this->locations[0]->lng, $order->lat, $order->lng);
            if ($min_dist > $dist) {
                $min_dist  = $dist;
                $min_order = $order;
            }
            if (!$min_order instanceof Order && $min_order == 0) {
                $min_order = $order;
                $min_dist  = $dist;
            }
        }
        $this->orders()->save($min_order);
    }

}

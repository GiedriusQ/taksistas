<?php

namespace App;

use App\GK\Utilities\Bing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * App\Order
 *
 * @property integer $id
 * @property integer $driver_id
 * @property integer $dispatcher_id
 * @property string $address
 * @property float $lat
 * @property float $lng
 * @property float $destination_lat
 * @property float $destination_lng
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereDriverId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereDispatcherId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereLng($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereDestinationLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereDestinationLng($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereUpdatedAt($value)
 * @property-read \App\User $dispatcher
 * @property-read \App\User $driver
 * @property-read mixed $status_str
 * @property string $from
 * @property string $to
 * @property string $client
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereClient($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\StatusHistory[] $statusHistory
 * @property-read mixed $added_at
 * @property-read mixed $created_at_readable
 * @method static \Illuminate\Database\Query\Builder|\App\Order assignedToDriver($driver)
 */
class Order extends Model
{
    use StatusAndDate;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from',
        'to',
        'client',
        'driver_id',
        'status',
        'lat',
        'lng',
        'destination_lat',
        'destination_lng'
    ];

//    protected $hidden = [];

    protected $appends = ['status_str', 'added_at', 'created_at_readable'];

    protected $casts = [
        'driver_id'       => 'int',
        'dispatcher_id'   => 'int',
        'id'              => 'int',
        'lat'             => 'double',
        'lng'             => 'double',
        'destination_lat' => 'double',
        'destination_lng' => 'double'
    ];

    public function dispatcher()
    {
        return $this->belongsTo('App\User', 'dispatcher_id');
    }

    public function driver()
    {
        return $this->belongsTo('App\User', 'driver_id');
    }

    public function statusHistory()
    {
        return $this->hasMany('App\StatusHistory')->latest();
    }

    public function scopeAssignedToDriver($query, $driver)
    {
        $query->whereDriverId($driver instanceof User ? $driver->id : $driver);
    }

    public function setStatus($user, $status)
    {
        $user_id      = $user instanceof Model ? $user->id : $user;
        $this->status = $status;
        $this->save();

        return $this->statusHistory()->create(['user_id' => $user_id, 'status' => $status]);
    }

    public function assignNearestDriver()
    {
        $drivers  = $this->dispatcher->drivers()->whereHas('orders', function ($q) {
            $q->where('status', '!=', 2);
        }, '=', 0)->has('locations')->get();
        $min_user = 0;
        $min_dist = 0;
        if (count($drivers) == 0) {
            return;
        }
        foreach ($drivers as $driver) {
            $dist = Bing::distanceBetweenTwoPoints($driver->locations[0]->lat,
                $driver->locations[0]->lng, $this->lat, $this->lng);
            if ($min_dist > $dist) {
                $min_dist = $dist;
                $min_user = $driver;
            }
            if ($min_user == 0) {
                $min_user = $driver;
                $min_dist = $dist;
            }
        }
        $this->driver()->associate($min_user);
    }
}

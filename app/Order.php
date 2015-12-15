<?php

namespace App;

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
 */
class Order extends Model
{
    use StatusAndDate;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['from', 'to', 'client', 'driver_id'];

    protected $hidden = ['driver_id', 'dispatcher_id', 'lat', 'lng', 'destination_lat', 'destination_lng'];

    protected $appends = ['status_str', 'added_at', 'created_at_readable'];

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

}

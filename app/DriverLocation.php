<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DriverLocation
 *
 * @property integer $id
 * @property integer $driver_id
 * @property float $lat
 * @property float $lng
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\DriverLocation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DriverLocation whereDriverId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DriverLocation whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DriverLocation whereLng($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DriverLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DriverLocation whereUpdatedAt($value)
 * @property-read \App\User $driver
 */
class DriverLocation extends Model
{
    public function driver()
    {
        return $this->belongsTo('App\User', 'driver_id');
    }
}

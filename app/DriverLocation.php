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
 * @property-read mixed $status_str
 * @property-read mixed $added_at
 * @property-read mixed $created_at_readable
 */
class DriverLocation extends Model
{
    use StatusAndDate;
    protected $fillable = ['lat', 'lng'];
    protected $appends = ['added_at', 'created_at_readable'];
    protected $casts = ['lat' => 'double', 'lng' => 'double'];

    public function driver()
    {
        return $this->belongsTo('App\User', 'driver_id');
    }
}

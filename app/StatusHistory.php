<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * App\StatusHistory
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\StatusHistory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StatusHistory whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StatusHistory whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StatusHistory whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StatusHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StatusHistory whereUpdatedAt($value)
 * @property-read \App\Order $order
 * @property-read \App\User $user
 * @property-read mixed $status_str
 */
class StatusHistory extends Model
{
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getStatusStrAttribute()
    {
        return Config::get('statuses.' . $this->status);
    }
}

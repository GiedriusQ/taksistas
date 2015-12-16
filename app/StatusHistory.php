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
 * @property-read mixed $added_at
 * @property-read mixed $created_at_readable
 * @method static \Illuminate\Database\Query\Builder|\App\StatusHistory createByUser($user)
 */
class StatusHistory extends Model
{
    use StatusAndDate;
    protected $fillable = ['user_id', 'status'];
    protected $hidden = ['id', 'updated_at', 'user_id', 'order_id'];
    protected $appends = ['status_str', 'added_at', 'created_at_readable'];

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

    public function scopeCreateByUser($query, $user)
    {
        $query->whereUserId($user instanceof User ? $user->id : $user);
    }
}

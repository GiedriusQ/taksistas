<?php

namespace App;

trait StatusAndDate
{
    public function getStatusStrAttribute()
    {
        return config('statuses.' . $this->status);
    }

    public function getAddedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getCreatedAtReadableAttribute()
    {
        return $this->created_at->toDateTimeString();
    }
}
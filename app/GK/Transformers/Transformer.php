<?php

namespace App\GK\Transformers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Transformer
{
    public function transformPaginator(LengthAwarePaginator $items)
    {
        return $items->map([$this, 'transform']);
    }

    public function transformCollection(Collection $items)
    {
        return $items->map([$this, 'transform']);
    }

    public function transformModel(Model $item)
    {
        return $this->transform($item->toArray());
    }

    public abstract function transform($item);
}
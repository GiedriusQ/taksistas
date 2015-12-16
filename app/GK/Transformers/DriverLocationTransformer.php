<?php

namespace App\GK\Transformers;

class DriverLocationTransformer extends Transformer
{

    public function transform($item)
    {
        return [
            'lat'        => $item['lat'],
            'lng'        => $item['lng'],
            'created_at' => $item['created_at_readable'],
            'date_diff'  => $item['added_at']
        ];
    }
}
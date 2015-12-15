<?php

namespace App\GK\Transformers;

class StatusTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'status'     => $item['status_str'],
            'created_at' => $item['created_at_readable'],
            'date_diff'  => $item['added_at']
        ];
    }

}
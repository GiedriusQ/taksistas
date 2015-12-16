<?php

namespace App\GK\Transformers;

class OrderTransformer extends Transformer
{
    public function transformArray(array $items = null)
    {
        return !$items ? [] : array_map([$this, 'transformStatusHistory'], $items);
    }

    public function transform($item)
    {
        return [
            'id'             => (int)$item['id'],
            'take_from'      => $item['from'],
            'transport_to'   => $item['to'],
            'status'         => $item['status_str'],
            'client'         => $item['client'],
            'created_at'     => $item['created_at_readable'],
            'date_diff'      => $item['added_at'],
            'status_history' => $this->transformArray($item['status_history'])
        ];
    }

    public function transformStatusHistory($item)
    {
        return [
            'status'     => $item['status_str'],
            'created_at' => $item['created_at_readable'],
            'date_diff'  => $item['added_at']
        ];
    }

}
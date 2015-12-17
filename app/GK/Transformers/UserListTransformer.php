<?php

namespace App\GK\Transformers;

class UserListTransformer extends Transformer
{

    public function transform($item)
    {
        return [
            'id'   => (int)$item['id'],
            'name' => $item['name']
        ];
    }
}
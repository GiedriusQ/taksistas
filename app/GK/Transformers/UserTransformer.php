<?php

namespace App\GK\Transformers;

class UserTransformer extends Transformer
{

    public function transform($item)
    {
        return [
            'id'    => $item['id'],
            'email' => $item['email'],
            'role'  => $item['role'],
            'type'  => $item['type'],
            'name'  => $item['name'],
            'city'  => $item['city']
        ];
    }
}
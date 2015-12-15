<?php

namespace App\GK\Transformers;

class UserTransformer extends Transformer
{

    public function transform($item)
    {
        return [
            'id'    => (int)$item['id'],
            'email' => $item['email'],
            'role'  => $item['role'],
            'name'  => $item['name'],
            'city'  => $item['city']
        ];
    }
}
<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'email'          => $faker->email,
        'type'           => 0,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'name'           => $faker->name,
        'city'           => $faker->city
    ];
});
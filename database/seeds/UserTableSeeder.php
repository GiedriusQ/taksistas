<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create 1 admin
        factory(App\User::class)->create(['password' => bcrypt('123456')]);

        //create 3 dispatchers
        $dispatchers = factory(App\User::class, 3)->create([
            'password' => bcrypt('123456'),
            'type'     => '1'
        ]);

        //create 2 drivers for each dispatcher
        $dispatchers->each(function ($dispatcher) {
            $dispatcher->drivers()->saveMany(factory(App\User::class, 2)->create([
                'password' => bcrypt('123456'),
                'type'     => '2'
            ]));
        });
    }
}

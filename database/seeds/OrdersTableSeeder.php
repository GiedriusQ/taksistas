<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $drivers = App\User::isDriver()->get();
        foreach ($drivers as $driver) {
            //create 5 orders for each driver
            $orders = factory(App\Order::class, 5)->make();
            $driver->dispatcher->orders()->saveMany($orders);
            $driver->orders()->saveMany($orders);
        }
    }
}

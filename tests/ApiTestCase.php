<?php

use App\User;

class ApiTestCase extends TestCase
{
    const password = '123456';
    private $email;

    protected function loginAs($user)
    {
        $this->email = $user->email;
    }

    protected function getJson($url)
    {
        $headers = [
            'HTTP_AUTHORIZATION' => 'Basic ' . base64_encode($this->email . ':' . self::password)
        ];

        return json_decode($this->get($url, $headers)->response->getContent());
    }

    protected function postJson($url, $data)
    {
        $headers = [
            'HTTP_AUTHORIZATION' => 'Basic ' . base64_encode($this->email . ':' . self::password)
        ];

        return json_decode($this->post($url, $data, $headers)->response->getContent());
    }

    protected function putJson($url, $data)
    {
        $headers = [
            'HTTP_AUTHORIZATION' => 'Basic ' . base64_encode($this->email . ':' . self::password)
        ];

        return json_decode($this->put($url, $data, $headers)->response->getContent());
    }

    protected function makeDrivers($number = 1)
    {
        return factory(App\User::class, $number)->make(['type' => '2', 'password' => self::password]);
    }

    protected function createDrivers($number = 1)
    {
        return factory(App\User::class, $number)->create(['type' => '2', 'password' => self::password]);
    }

    protected function createDispatchers($number = 1)
    {
        return factory(App\User::class, $number)->create(['type' => '1', 'password' => self::password]);
    }

    protected function createAdmins($number = 1)
    {
        return factory(App\User::class, $number)->create(['type' => '0', 'password' => self::password]);
    }

    protected function createOrders(User $driver, $number = 1)
    {
        $orders = factory(App\Order::class, $number)->make();
        $orders = $number == 1 ? [$orders] : $orders;
        $driver->dispatcher->orders()->saveMany($orders);
        $driver->orders()->saveMany($orders);

        return $number == 1 ? $orders[0] : $orders;
    }

}
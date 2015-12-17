<?php
namespace App\GK\Utilities;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class API
{
    const base_url = 'http://localhost:88';
    const login_url = self::base_url . '/api/login';

    const admin_admins = self::base_url . '/api/admin/users/admins/detailed';
    const admin_dispatchers = self::base_url . '/api/admin/users/dispatchers/detailed';
    const admin_drivers = self::base_url . '/api/admin/users/drivers/detailed';

    const admin_dispatchers_drivers = self::base_url . '/api/admin/dispatchers';

    const admin_admins_list = self::base_url . '/api/admin/users/admins';
    const admin_dispatchers_list = self::base_url . '/api/admin/users/dispatchers';
    const admin_drivers_list = self::base_url . '/api/admin/users/drivers';
    const admin_users = self::base_url . '/api/admin/users';

    const admin_orders = self::base_url . '/api/admin/orders';

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function checkCrediantials()
    {
        try {
            return json_decode($this->client->request('POST', self::login_url, [
                'form_params' => ['email' => session('email'), 'password' => session('password')]
            ])->getBody()->getContents());
        } catch (ClientException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    public function call($url, $method = 'GET', $data = [])
    {
        try {
            return json_decode($this->client->request($method, $url, [
                'auth'        => [session('email'), session('password')],
                'form_params' => $data
            ])->getBody()->getContents());
        } catch (ClientException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }
}
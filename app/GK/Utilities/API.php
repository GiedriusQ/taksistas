<?php
namespace App\GK\Utilities;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class API
{
    const base_url = 'http://localhost:88';
    const login_url = self::base_url . '/api/login';
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
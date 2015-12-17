<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminApiTest extends ApiTestCase
{
    use DatabaseMigrations;
    private $admin;

    public function init()
    {
        //create main admin
        $this->admin = $this->createAdmins();
        $this->loginAs($this->admin);
    }

    /** @test */
    public function it_fetches_admins_and_count_them()
    {
        $this->init();
        $admins = $this->getJson('api/admin/users/admins/detailed');
        $this->assertResponseOk();
        $this->assertObjectHasAttribute('data', $admins);
        $this->assertObjectHasAttribute('paginator', $admins);
        $admins_now = $admins->paginator->total;

        //create 10 more admins
        $admins = $this->createAdmins(10);

        $admins = $this->getJson('api/admin/users/admins/detailed');
        $this->assertResponseOk();
        $this->assertObjectHasAttribute('data', $admins);
        $this->assertObjectHasAttribute('paginator', $admins);
        $this->assertEquals($admins_now + 10, $admins->paginator->total);

        //check object attribute values
        $this->assertAttributeEquals($this->admin->id, 'id', $admins->data[0]);
        $this->assertAttributeEquals($this->admin->role, 'role', $admins->data[0]);
        $this->assertAttributeEquals($this->admin->email, 'email', $admins->data[0]);
        $this->assertAttributeEquals($this->admin->name, 'name', $admins->data[0]);
        $this->assertAttributeEquals($this->admin->city, 'city', $admins->data[0]);
    }

    /** @test */
    public function it_adds_new_admin()
    {
        $this->init();
        $admins = $this->postJson('api/admin/users/admins',
            ['name' => 'Demo test', 'city' => 'Kaunas', 'email' => 'foo@bar.com', 'password' => 'longpassword']);
        $this->assertResponseStatus(201);
        $this->assertObjectHasAttribute('data', $admins);

        //check object attribute values
        $this->assertAttributeEquals('administrator', 'role', $admins->data);
        $this->assertAttributeEquals('foo@bar.com', 'email', $admins->data);
        $this->assertAttributeEquals('Demo test', 'name', $admins->data);
        $this->assertAttributeEquals('Kaunas', 'city', $admins->data);

        //check if row actually exists in database
        $this->seeInDatabase('users', ['name' => 'Demo test', 'city' => 'Kaunas', 'email' => 'foo@bar.com']);
    }

    /** @test */
    public function it_fetches_dispatchers_and_count_them()
    {
        $this->init();
        $dispatchers = $this->getJson('api/admin/users/dispatchers/detailed');
        $this->assertResponseOk();
        $this->assertObjectHasAttribute('data', $dispatchers);
        $this->assertObjectHasAttribute('paginator', $dispatchers);
        $total = $dispatchers->paginator->total;

        //create 10 more admins
        $dispatchers = $this->createDispatchers(10);
        $dispatcher  = $dispatchers[0];

        $dispatchers = $this->getJson('api/admin/users/dispatchers/detailed');
        $this->assertResponseOk();
        $this->assertObjectHasAttribute('data', $dispatchers);
        $this->assertObjectHasAttribute('paginator', $dispatchers);
        $this->assertEquals($total + 10, $dispatchers->paginator->total);

        //check object attribute values
        $this->assertAttributeEquals($dispatcher->id, 'id', $dispatchers->data[0]);
        $this->assertAttributeEquals($dispatcher->role, 'role', $dispatchers->data[0]);
        $this->assertAttributeEquals($dispatcher->email, 'email', $dispatchers->data[0]);
        $this->assertAttributeEquals($dispatcher->name, 'name', $dispatchers->data[0]);
        $this->assertAttributeEquals($dispatcher->city, 'city', $dispatchers->data[0]);
    }

    /** @test */
    public function it_adds_new_dispatcher()
    {
        $this->init();
        $dispatcher = $this->postJson('api/admin/users/dispatchers',
            [
                'name'     => 'Demo test dispatcher',
                'city'     => 'Kaunas',
                'email'    => 'foo@bar.com',
                'password' => 'longpassword'
            ]);
        $this->assertResponseStatus(201);
        $this->assertObjectHasAttribute('data', $dispatcher);

        //check object attribute values
        $this->assertAttributeEquals('dispatcher', 'role', $dispatcher->data);
        $this->assertAttributeEquals('foo@bar.com', 'email', $dispatcher->data);
        $this->assertAttributeEquals('Demo test dispatcher', 'name', $dispatcher->data);
        $this->assertAttributeEquals('Kaunas', 'city', $dispatcher->data);

        //check if row actually exists in database
        $this->seeInDatabase('users', ['name' => 'Demo test dispatcher', 'city' => 'Kaunas', 'email' => 'foo@bar.com']);
    }
}

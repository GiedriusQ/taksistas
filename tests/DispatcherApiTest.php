<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DispatcherApiTest extends ApiTestCase
{
    use DatabaseMigrations;
    private $dispatcher;

    public function init()
    {
        //create main admin
        $this->dispatcher = $this->createDispatchers();
        $this->loginAs($this->dispatcher);
    }

    /** @test */
    public function it_fetches_drivers()
    {
        $this->init();
        //create 3 drivers for dispatcher
        $drivers = $this->dispatcher->drivers()->saveMany($this->makeDrivers(3));

        $drivers = $this->getJson('api/dispatcher/drivers');
        $this->assertResponseOk();
        $this->assertObjectHasAttribute('data', $drivers);
        $this->assertObjectHasAttribute('paginator', $drivers);
        $this->assertCount(3, $drivers->data);

        //create 3 orders for each driver
//        $drivers->each(function($driver){
//            $this->createOrders($driver,3);
//        });
    }

    /** @test */
    public function it_create_and_fetches_single_driver()
    {
        $this->init();
        //create 1 driver for dispatcher
        $driverX = $this->dispatcher->drivers()->save($this->makeDrivers());
        $driver  = $this->getJson('api/dispatcher/drivers/' . $driverX->id);
        $this->assertResponseOk();
        $this->assertObjectHasAttribute('data', $driver);
        $this->assertAttributeEquals($driverX->id, 'id', $driver->data);
        $this->assertAttributeEquals($driverX->role, 'role', $driver->data);
        $this->assertAttributeEquals($driverX->email, 'email', $driver->data);
        $this->assertAttributeEquals($driverX->name, 'name', $driver->data);
        $this->assertAttributeEquals($driverX->city, 'city', $driver->data);
    }

    /** @test */
    public function it_creates_and_delete_single_driver()
    {
        $this->init();
        //create 1 driver for dispatcher
        $driverX = $this->dispatcher->drivers()->save($this->makeDrivers());
        $driver  = $this->deleteJson('api/dispatcher/drivers/' . $driverX->id);
        $this->assertResponseOk();
        $this->assertEquals('Resource deleted successfully', $driver->status);

        $driver = $this->deleteJson('api/dispatcher/drivers/' . $driverX->id);
        $this->assertResponseStatus(404);
        $this->assertEquals('Resource not found!', $driver->error->message);
    }

    /** @test */
    public function it_creates_driver_and_assign_5_orders()
    {
        $this->init();
        $driverX = $this->dispatcher->drivers()->save($this->makeDrivers());
        $ordersX = $this->createOrders($driverX, 5);
        $orders  = $this->getJson('api/dispatcher/drivers/' . $driverX->id . '/orders');
        $this->assertResponseOk();
        $this->assertObjectHasAttribute('data', $orders);
        $this->assertCount(5, $orders->data);
    }
}

<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DriverApiTest extends ApiTestCase
{
    use DatabaseMigrations;
    private $driver;

    public function init()
    {
        //create driver
        $this->driver = $this->driver();
    }

    /** @test */
    public function it_fetches_0_order()
    {
        $this->init();
        $orders = $this->getJson('api/driver/orders');
        $this->assertResponseOk();
        $this->assertObjectHasAttribute('paginator', $orders);
        $this->assertObjectHasAttribute('data', $orders);
        $this->assertEquals(0, $orders->paginator->total);
        $this->assertEquals(0, count($orders->data));
    }

    /** @test */
    public function it_fetches_10_orders_and_check_attributes()
    {
        $this->init();
        //create 10 orders
        $orders = $this->createOrders($this->driver, 10);

        $json = $this->getJson('api/driver/orders');
        $this->assertResponseOk();
        $this->assertObjectHasAttribute('paginator', $json);
        $this->assertObjectHasAttribute('data', $json);
        $this->assertEquals(10, $json->paginator->total);
        $this->assertCount(10, $json->data);

        //check object attribute values
        $first_order = $orders->sortByDesc('created_at')->first();
        $this->assertAttributeEquals($first_order->id, 'id', $json->data[0]);
        $this->assertAttributeEquals($first_order->from, 'take_from', $json->data[0]);
        $this->assertAttributeEquals($first_order->to, 'transport_to', $json->data[0]);
        $this->assertAttributeEquals($first_order->client, 'client', $json->data[0]);
        $this->assertAttributeEquals($first_order->created_at, 'created_at', $json->data[0]);
    }

    /** @test */
    public function it_adds_and_checks_order_status()
    {
        $this->init();
        $order     = $this->createOrders($this->driver);
        $locations = $this->putJson('api/driver/orders/' . $order->id, ['status' => 2]);
        $this->assertResponseOk();

        $locations = $this->getJson('api/driver/orders/' . $order->id);
        $this->assertResponseOk();
        $this->assertObjectHasAttribute('data', $locations);
        $this->assertEquals(config('statuses.2'), $locations->data->status);
    }

    /** @test */
    public function it_adds_and_checks_driver_location()
    {
        $this->init();
        $locations = $this->getJson('api/driver/locations');

        $this->assertResponseOk();
        $this->assertObjectHasAttribute('data', $locations);
        $this->assertEquals([], $locations->data);

        $locations = $this->postJson('api/driver/locations', ['lat' => 12.34567898, 'lng' => 21.43567895]);
        $this->assertResponseStatus(201);
        $this->assertObjectHasAttribute('status', $locations);
        $this->assertObjectHasAttribute('status_code', $locations);
        $this->assertEquals('Resource created successfully', $locations->status);
        $this->assertEquals('201', $locations->status_code);

        $locations = $this->getJson('api/driver/locations');
        $this->assertResponseOk();
        $this->assertObjectHasAttribute('data', $locations);
        $this->assertEquals(12.34567898, $locations->data->lat);
        $this->assertEquals(21.43567895, $locations->data->lng);
    }

    protected function driver()
    {
        //make 1 driver
        $driver = $this->makeDrivers();
        //create 1 dispatcher
        $dispatcher = $this->createDispatchers();
        //attache driver to dispatcher
        $dispatcher->drivers()->save($driver);
        //login as driver
        $this->loginAs($driver);

        return $driver;
    }
}

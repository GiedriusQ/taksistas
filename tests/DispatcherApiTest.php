<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DispatcherApiTest extends ApiTestCase
{
//    use DatabaseMigrations;

    /** @test */
    public function it_fetches_admins()
    {
        //create main admin
//        $admin = factory(App\User::class)->create(['password' => 'test123', 'type' => 0]);

        //create 10 more admins
//        $admins = factory(App\User::class, 10)->create(['type' => 0]);
//
//        $headers = [
//            'HTTP_AUTHORIZATION' => 'Basic ' . base64_encode($admin->email . ':test123')
//        ];
//
//        $admins = $this->getJson('api/admin/users/admins', $headers);
//        $this->assertResponseOk();
//        $this->assertObjectHasAttribute('data', $admins);
//        $this->assertObjectHasAttribute('paginator', $admins);
//        $this->assertEquals(11, count($admins->data));
    }
}

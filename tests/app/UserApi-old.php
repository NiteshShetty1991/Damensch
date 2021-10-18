<?php

namespace App;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class UserApiTest extends CIUnitTestCase
{
    use DatabaseTestTrait, FeatureTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /*public function testStoreUser()
    {
        $result = $this->call('post', 'userCreate', [
                        'fullname'  => 'NiteshShetty',
                        'username'  => 'NiteshShetty4',
                        'password'  => 'qwerty@asd',
                        'email' => 'niteshatindia4@gmail.com'
                    ]);
        $result->assertOK();
    }*/

    public function testGetAllUser()
    {
        $headers = [
            'CONTENT_TYPE' => 'application/json',
        ];
        $result = $this->withHeaders($headers)->get('user');
        echo "<pre>";print_r($result);exit;
        $result->assertOK();
        /*$response = $result->response();
        //echo "<pre>";print_r($response);exit;
        $this->assertEquals(200, $response->statusCode);*/
    }
}
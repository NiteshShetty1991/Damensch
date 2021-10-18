<?php

namespace App;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use GuzzleHttp\Client;


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

    public function testStoreUser()
    {
        global $access_token;
        $url = 'http://localhost:8080/userCreate';
        $guzzleClient = new Client([
            'verify'    =>  false
        ]);
        //echo 'niteshatindia'.date("Y-m-dH:i:s").'@gmail.com';exit;
        try {
            $response = $guzzleClient->request('POST', $url, array(
                'debug'     =>  false,
                'form_params'   =>  array(
                    'fullname'  => 'NiteshShetty',
                    'username'  => 'NiteshShetty4'.date("Y-m-d H:i:s"),
                    'password'  => 'qwerty@asd',
                    'email' => 'niteshatindia'.date("YmdHis").'@gmail.com'
                )
            ));
            $statusCode = $response->getStatusCode();
            $contents = json_decode($response->getBody()->getContents(),true);
        } catch (ClientException $e) {
            die((string)$e->getResponse()->getBody());
        }
        $this->assertEquals(200, $statusCode);
        $access_token = $contents["access_token"];
        //return $contents["access_token"];
    }

    public function testGetAllUser()
    {
        global $access_token;
        $url = 'http://localhost:8080/user';

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$access_token
        ];


        $guzzleClient = new Client([
            'verify'    =>  false,
            'headers' => $headers
        ]);

        try {
            $response = $guzzleClient->request('get', $url, array(
                'debug'     =>  false
            ));
            $statusCode = $response->getStatusCode();
        } catch (ClientException $e) {
            die((string)$e->getResponse()->getBody());
        }
        $this->assertEquals(200, $statusCode);
    }

    public function testGetSingleUser()
    {
        global $access_token;
        $url = 'http://localhost:8080/user/3';

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$access_token
        ];

        $guzzleClient = new Client([
            'verify'    =>  false,
            'headers' => $headers
        ]);

        try {
            $response = $guzzleClient->request('get', $url, array(
                'debug'     =>  false
            ));
            $statusCode = $response->getStatusCode();
        } catch (ClientException $e) {
            die((string)$e->getResponse()->getBody());
        }
        $this->assertEquals(200, $statusCode);
    }

    public function testUpdateUser()
    {
        global $access_token;
        $url = 'http://localhost:8080/user/3';

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$access_token
        ];

        $guzzleClient = new Client([
            'verify'    =>  false,
            'headers' => $headers
        ]);

        try {
            $response = $guzzleClient->request('POST', $url, array(
                'debug'     =>  false,
                'form_params'   =>  array(
                    'fullname'  => 'NiteshShetty',
                    'username'  => 'NiteshShetty4'.date("m-d H:i:s"),
                    'password'  => 'qwerty@asd',
                    'email' => 'niteshatindia'.date("mdHis").'@gmail.com'
                )
            ));
            $statusCode = $response->getStatusCode();
        } catch (ClientException $e) {
            die((string)$e->getResponse()->getBody());
        }
        $this->assertEquals(200, $statusCode);
    }

    public function testDeleteUser()
    {
        global $access_token;
        $url = 'http://localhost:8080/user/3';

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$access_token
        ];

        $guzzleClient = new Client([
            'verify'    =>  false,
            'headers' => $headers
        ]);

        try {
            $response = $guzzleClient->request('delete', $url, array(
                'debug'     =>  false
            ));
            $statusCode = $response->getStatusCode();
        } catch (ClientException $e) {
            die((string)$e->getResponse()->getBody());
        }
        $this->assertEquals(200, $statusCode);
    }
}
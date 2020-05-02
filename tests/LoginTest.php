<?php


namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends WebTestCase
{

    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testLoginSuccess()
    {
        $token = $this->client->getContainer()->get('security.csrf.token_manager')->getToken('authenticate');
        $this->client->request('POST', '/login', ['email' => 'akshayachar2011@gmail.com', 'password' => 'akshay', '_csrf_token' => $token->getValue()]);
        $this->assertSame('/homepage', $this->client->getResponse()->getTargetUrl());
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testLoginFail()
    {
        $token = $this->client->getContainer()->get('security.csrf.token_manager')->getToken('authenticate');
        $this->client->request('POST', '/login', ['email' => 'akshayachar2011@gmail.com', 'password' => 'abc', '_csrf_token' => $token->getValue() ]);
        $this->assertSame('/login', $this->client->getResponse()->getTargetUrl());
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
    }
}
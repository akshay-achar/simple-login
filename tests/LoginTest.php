<?php


namespace App\Tests;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class LoginTest extends WebTestCase
{

    private $client;

    private $email;

    private $password;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->email = 'abc'.rand(1,10000).'@gmail.com';
        $this->password = 'abc!@*'.rand(1, 1000);
    }

    public function testLoginSuccess()
    {
        $this->insertToUser();
        $token = $this->client->getContainer()->get('security.csrf.token_manager')->getToken('authenticate');
        $this->client->request('POST', '/login', ['email' => $this->email, 'password' => $this->password, '_csrf_token' => $token->getValue()]);
        $this->assertSame('/homepage', $this->client->getResponse()->getTargetUrl());
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testLoginFail()
    {
        $token = $this->client->getContainer()->get('security.csrf.token_manager')->getToken('authenticate');
        $this->client->request('POST', '/login', ['email' => $this->email, 'password' => 'abc', '_csrf_token' => $token->getValue() ]);
        $this->assertSame('/login', $this->client->getResponse()->getTargetUrl());
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function insertToUser()
    {
        /**
         * @var $entityManager EntityManagerInterface
         */
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        /**
         * @var $userPasswordEncoder UserPasswordEncoder
         */
        $userPasswordEncoder = $this->client->getContainer()->get('security.password_encoder');
        $user = new User();
        $user->setEmail($this->email);
        $encodedPassword = $userPasswordEncoder->encodePassword($user, $this->password);
        $user->setPassword($encodedPassword);
        $entityManager->persist($user);
        $entityManager->flush();
    }

}
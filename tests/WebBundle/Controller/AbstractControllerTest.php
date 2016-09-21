<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\WebBundle\Controller;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

abstract class AbstractControllerTest extends WebTestCase
{
    /**
     * @var ReferenceRepository
     */
    protected $referenceRepository;

    /**
     * @var Client
     */
    protected $client;

    protected function setUp()
    {
        /** @var ORMExecutor $executor */
        $executor = $this->loadFixtures($this->getFixtureClasses());
        $this->referenceRepository = $executor->getReferenceRepository();
        $this->client = static::makeClient();
    }

    /**
     * @param User $user
     */
    protected function logIn(User $user)
    {
        $session = $this->client->getContainer()->get('session');

        $firewall = 'main';
        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    protected function logOut()
    {
        $session = $this->client->getContainer()->get('session');
        $session->clear();
        $session->save();

        $this->client->getCookieJar()->clear();
    }

    protected function assertLoginRequired()
    {
        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertEquals('http://localhost/twig/login', $this->client->getResponse()->headers->get('location'));
    }

    /**
     * @return string[]
     */
    abstract protected function getFixtureClasses();
}

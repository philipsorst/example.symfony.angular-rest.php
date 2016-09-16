<?php


namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\ApiKey;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

abstract class RestControllerTestCase extends WebTestCase
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

        $this->client = static::createClient();
    }

    /**
     * @param Response $response
     * @param int      $statusCode
     *
     * @return array
     */
    protected function assertJsonResponse(Response $response, $statusCode = 200)
    {
        $content = $response->getContent();
        $this->assertEquals(
            $statusCode,
            $response->getStatusCode(),
            $content
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );

        return json_decode($content, true);
    }

    /**
     * @param string $name
     *
     * @return NewsEntry
     */
    protected function getNewsEntryReference($name)
    {
        return $this->referenceRepository->getReference($name);
    }

    /**
     * @param string $name
     *
     * @return User
     */
    protected function getUserReference($name)
    {
        return $this->referenceRepository->getReference($name);
    }

    /**
     * @param $name
     *
     * @return ApiKey
     */
    protected function getApiKeyReference($name)
    {
        return $this->referenceRepository->getReference($name);
    }

    /**
     * @return string[]
     */
    abstract protected function getFixtureClasses();
}

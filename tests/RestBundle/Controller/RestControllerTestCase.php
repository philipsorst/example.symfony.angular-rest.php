<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\ApiKey;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Request;
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
     * @param string      $url
     * @param array       $parameters
     * @param ApiKey|null $apiKey
     *
     * @return Response
     */
    protected function doGetRequest($url, $parameters = [], ApiKey $apiKey = null)
    {
        $headers = [];
        if (null !== $apiKey) {
            $headers['X-API-KEY'] = $apiKey->getKey();
        }
        $this->client->request(
            Request::METHOD_GET,
            $url,
            $parameters,
            [],
            $this->transformHeaders($headers)
        );
        $response = $this->client->getResponse();

        return $response;
    }

    /**
     * @param string      $url
     * @param array       $content
     * @param ApiKey|null $apiKey
     *
     * @return Response
     */
    protected function doPostRequest($url, $content, ApiKey $apiKey = null)
    {
        $headers = [];
        if (null !== $apiKey) {
            $headers['X-API-KEY'] = $apiKey->getKey();
        }
        $this->client->request(
            Request::METHOD_POST,
            $url,
            [],
            [],
            $this->transformHeaders($headers),
            json_encode($content)
        );
        $response = $this->client->getResponse();

        return $response;
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
     * @return BlogPost
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
     * @param array $headers
     *
     * @return array
     */
    protected function transformHeaders(array $headers)
    {
        $transformedHeaders = [
            'HTTP_ACCEPT'  => 'application/json',
            'CONTENT_TYPE' => 'application/json'
        ];
        foreach ($headers as $key => $value) {
            $transformedHeaders['HTTP_' . $key] = $value;
        }

        return $transformedHeaders;
    }

    /**
     * @return string[]
     */
    abstract protected function getFixtureClasses();
}

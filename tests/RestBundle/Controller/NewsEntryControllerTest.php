<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\ApiKeys;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Comments;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\NewsEntries;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsEntryControllerTest extends RestControllerTestCase
{
    public function testListNewsEntries()
    {
        $response = $this->doGetRequest('/rest/newsentries');
        $content = $this->assertJsonResponse($response, Response::HTTP_OK);
        $this->assertCount(2, $content);
        $newsEntry2 = $this->getNewsEntryReference(NewsEntries::NEWS_ENTRY_2);
        $user = $this->getUserReference(Users::ADMIN);
        $expectedContent = [
            'id'           => $newsEntry2->getId(),
            'title'        => $newsEntry2->getTitle(),
            'content'      => $newsEntry2->getContent(),
            'date'         => $newsEntry2->getDate()->format('Y-m-d\TH:i:sO'),
            'num_comments' => $newsEntry2->getNumComments(),
            'author'       => [
                'id'       => $user->getId(),
                'username' => $user->getUsername()
            ]
        ];

        $this->assertEquals($expectedContent, $content[1]);
    }

    public function testGetNewsEntry()
    {
        $response = $this->doGetRequest('/rest/newsentries/1');
        $content = $this->assertJsonResponse($response, Response::HTTP_OK);
        $newsEntry = $this->getNewsEntryReference(NewsEntries::NEWS_ENTRY_1);
        $user = $this->getUserReference('user');
        $expectedContent = [
            'id'           => $newsEntry->getId(),
            'title'        => $newsEntry->getTitle(),
            'content'      => $newsEntry->getContent(),
            'date'         => $newsEntry->getDate()->format('Y-m-d\TH:i:sO'),
            'num_comments' => $newsEntry->getNumComments(),
            'author'       => [
                'id'       => $user->getId(),
                'username' => $user->getUsername()
            ]
        ];

        $this->assertEquals($expectedContent, $content);
    }

    public function testCreateNewsEntry()
    {
        $response = $this->doPostRequest(
            '/rest/newsentries',
            ['title' => 'TestTitle', 'content' => 'TestContent'],
            $this->getApiKeyReference(ApiKeys::ADMIN_API_KEY)
        );
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testCreateInvalidNewsEntry()
    {
        /* Content is missing */
        $response = $this->doPostRequest(
            '/rest/newsentries',
            ['title' => 'TestTitle'],
            $this->getApiKeyReference(ApiKeys::ADMIN_API_KEY)
        );
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testGetMissingNewsEntry()
    {
        $response = $this->doGetRequest('/rest/newsentries/666');
        $this->assertJsonResponse($response, Response::HTTP_NOT_FOUND);
    }

    /**
     * @return string[]
     */
    protected function getFixtureClasses()
    {
        return [
            Users::class,
            NewsEntries::class,
            Comments::class,
            ApiKeys::class
        ];
    }
}

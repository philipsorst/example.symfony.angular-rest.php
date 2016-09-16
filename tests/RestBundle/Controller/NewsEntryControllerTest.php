<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Comments;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\NewsEntries;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Users;

class NewsEntryControllerTest extends RestControllerTestCase
{
    public function testListNewsEntries()
    {
        $route = $this->getUrl('ddr_symfony_angular_rest_example_rest_newsentry_list_news_entries');

        $this->client->request('GET', $route, [], [], ['HTTP_ACCEPT' => 'application/json']);
        $response = $this->client->getResponse();

        $content = $this->assertJsonResponse($response, 200);
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
        $route = $this->getUrl('ddr_symfony_angular_rest_example_rest_newsentry_get_news_entry', ['id' => 1]);

        $this->client->request('GET', $route, [], [], ['HTTP_ACCEPT' => 'application/json']);
        $response = $this->client->getResponse();

        $content = $this->assertJsonResponse($response, 200);

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

    public function testGetMissingNewsEntry()
    {
        $route = $this->getUrl('ddr_symfony_angular_rest_example_rest_newsentry_get_news_entry', ['id' => 666]);

        $this->client->request('GET', $route, [], [], ['HTTP_ACCEPT' => 'application/json']);
        $response = $this->client->getResponse();

        $content = $this->assertJsonResponse($response, 404);
    }

    /**
     * @return string[]
     */
    protected function getFixtureClasses()
    {
        return [
            Users::class,
            NewsEntries::class,
            Comments::class
        ];
    }
}

<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Tests\Controller;

class NewsEntryControllerTest extends RestControllerTestCase
{
    public function testGetNewsEntry()
    {
        $route = $this->getUrl('ddr_symfony_angular_rest_example_rest_newsentry_get_news_entry', ['id' => 1]);

        $this->client->request('GET', $route, [], [], ['HTTP_ACCEPT' => 'application/json']);
        $response = $this->client->getResponse();

        $content = $this->assertJsonResponse($response, 200);

        $newsEntry = $this->getNewsEntryReference('news-entry-1');
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
            'Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Users',
            'Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\NewsEntries',
            'Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Comments'
        ];
    }
}

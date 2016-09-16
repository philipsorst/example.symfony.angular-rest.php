<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Tests\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\ApiKeys;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Users;

class UserControllerTest extends RestControllerTestCase
{

    public function testGetUser()
    {
        $route = $this->getUrl('ddr_symfony_angular_rest_example_rest_user_get_user', ['id' => 1]);
        $headers = [
            'HTTP_ACCEPT'    => 'application/json',
            'HTTP_X-API-KEY' => $this->getApiKeyReference(ApiKeys::ADMIN_API_KEY)->getKey()
        ];
        $this->client->request('GET', $route, [], [], $headers);
        $response = $this->client->getResponse();

        $content = $this->assertJsonResponse($response, 200);

        $user = $this->getUserReference(Users::ADMIN);
        $expectedContent = [
            'id'       => (int)$user->getId(),
            'username' => $user->getUsername(),
            'roles'    => ['ROLE_ADMIN']
        ];

        $this->assertEquals($expectedContent, $content);
    }

    /**
     * @return string[]
     */
    protected function getFixtureClasses()
    {
        return [
            Users::class,
            ApiKeys::class
        ];
    }
}

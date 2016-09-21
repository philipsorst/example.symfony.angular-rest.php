<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\ApiKeys;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Users;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends RestControllerTestCase
{

    public function testGetUser()
    {
        $response = $this->doGetRequest('/rest/users/1', [], $this->getApiKeyReference(ApiKeys::ADMIN_API_KEY));
        $content = $this->assertJsonResponse($response, Response::HTTP_OK);
        $user = $this->getUserReference(Users::ADMIN);
        $expectedContent = [
            'id'       => (int)$user->getId(),
            'username' => $user->getUsername(),
            'roles'    => ['ROLE_ADMIN']
        ];
        $this->assertEquals($expectedContent, $content);
    }

    public function testCreateApiKey()
    {
        $url = '/rest/apikeys';
        $response = $this->doPostRequest($url, ['username' => Users::USER, 'password' => Users::USER_PASSWORD], null);
        $content = $this->assertJsonResponse($response, Response::HTTP_CREATED);
        $this->assertNotEmpty($content['key']);
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

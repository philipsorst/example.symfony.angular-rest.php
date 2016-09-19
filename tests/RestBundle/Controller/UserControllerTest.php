<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\ApiKeys;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Users;

class UserControllerTest extends RestControllerTestCase
{

    public function testGetUser()
    {
        $response = $this->doGetRequest('/rest/users/1', [], $this->getApiKeyReference(ApiKeys::ADMIN_API_KEY));
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

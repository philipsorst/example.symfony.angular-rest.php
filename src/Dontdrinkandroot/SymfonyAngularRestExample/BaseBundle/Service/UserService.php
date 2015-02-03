<?php


namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\ApiKey;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;

interface UserService
{

    /**
     * @return User[]
     */
    public function listUsers();

    /**
     * @param int $id
     *
     * @return User
     */
    public function getUser($id);

    /**
     * @param string $userName
     * @param string $password
     *
     * @return ApiKey
     */
    public function createApiKey($userName, $password);

    /**
     * @param string $apiKey
     *
     * @return User|null
     */
    public function findUserByApiKey($apiKey);
}
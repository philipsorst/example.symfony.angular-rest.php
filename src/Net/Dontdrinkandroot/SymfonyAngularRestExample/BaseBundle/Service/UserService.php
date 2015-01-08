<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;

interface UserService
{

    /**
     * @return User[]
     */
    public function listUsers();

    /**
     * @param integer $id
     *
     * @return User
     */
    public function getUser($id);
}
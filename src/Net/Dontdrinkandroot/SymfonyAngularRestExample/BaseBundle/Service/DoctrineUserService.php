<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository\UserRepository;

class DoctrineUserService implements UserService
{

    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return User[]
     */
    public function listUsers()
    {
        // TODO: Implement listUsers() method.
    }

    /**
     * @param integer $id
     *
     * @return User
     */
    public function getUser($id)
    {
        // TODO: Implement getUser() method.
    }
}
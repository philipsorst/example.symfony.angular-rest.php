<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Exception\ResourceNotFoundException;
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
        $users = $this->userRepository->findAll();

        return $users;
    }

    /**
     * @param integer $id
     *
     * @return User
     *
     * @throws ResourceNotFoundException
     */
    public function getUser($id)
    {
        $user = $this->userRepository->find($id);
        if (null === $user) {
            throw new ResourceNotFoundException();
        }

        return $user;
    }
}
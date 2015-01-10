<?php

namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApiKey
 */
class ApiKey
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $key;

    /**
     * @var User
     */
    private $user;

    /**
     * Set id
     *
     * @param string $id
     *
     * @return ApiKey
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set key
     *
     * @param string $key
     *
     * @return ApiKey
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return ApiKey
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}

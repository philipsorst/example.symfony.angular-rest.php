<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser implements Entity
{
    /**
     * @var Collection
     */
    private $blogPosts;

    /**
     * @var Collection
     */
    private $apiKeys;

    /**
     * @var Collection
     */
    private $comments;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->blogPosts = new ArrayCollection();
        $this->apiKeys = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }
}

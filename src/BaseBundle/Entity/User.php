<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User
 */
class User extends BaseUser implements Entity
{

    /**
     * @var Collection
     */
    private $newsEntries;

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
        $this->newsEntries = new ArrayCollection();
        $this->apiKey = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * Add newsEntries
     *
     * @param NewsEntry $newsEntry
     *
     * @return User
     */
    public function addNewsEntry(NewsEntry $newsEntry)
    {
        $this->newsEntries[] = $newsEntry;

        return $this;
    }

    /**
     * Remove newsEntries
     *
     * @param NewsEntry $newsEntry
     */
    public function removeNewsEntry(NewsEntry $newsEntry)
    {
        $this->newsEntries->removeElement($newsEntry);
    }

    /**
     * Get newsEntries
     *
     * @return Collection
     */
    public function getNewsEntries()
    {
        return $this->newsEntries;
    }

    /**
     * Add apiKeys
     *
     * @param ApiKey $apiKey
     *
     * @return User
     */
    public function addApiKey(ApiKey $apiKey)
    {
        $this->apiKeys[] = $apiKey;

        return $this;
    }

    /**
     * Remove apiKeys
     *
     * @param ApiKey $apiKey
     */
    public function removeApiKey(ApiKey $apiKey)
    {
        $this->apiKeys->removeElement($apiKey);
    }

    /**
     * Get apiKeys
     *
     * @return Collection
     */
    public function getApiKeys()
    {
        return $this->apiKeys;
    }

    /**
     * Add comments
     *
     * @param Comment $comments
     *
     * @return User
     */
    public function addComment(Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param Comment $comments
     */
    public function removeComment(Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}

<?php

namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity;

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
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->newsEntries = new ArrayCollection();
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
}

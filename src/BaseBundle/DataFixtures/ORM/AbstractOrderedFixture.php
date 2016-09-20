<?php


namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;

abstract class AbstractOrderedFixture extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * @param string $name
     *
     * @return User
     */
    protected function getUserReference($name)
    {
        return $this->getReference($name);
    }

    /**
     * @param string $name
     *
     * @return BlogPost
     */
    protected function getBlogPostReference($name)
    {
        return $this->getReference($name);
    }
}

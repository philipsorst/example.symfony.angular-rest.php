<?php


namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture as BaseFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;

abstract class AbstractFixture extends BaseFixture
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

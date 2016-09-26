<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;

trait ReferenceTrait
{
    /**
     * @param string $name
     *
     * @return User
     */
    protected function getUserReference($name)
    {
        return $this->getAssertedReference($name, User::class);
    }

    /**
     * @param string $name
     *
     * @return BlogPost
     */
    protected function getBlogPostReference($name)
    {
        return $this->getAssertedReference($name, BlogPost::class);
    }

    /**
     * @param string $name
     * @param string $class
     *
     * @return mixed
     */
    protected function getAssertedReference($name, $class)
    {
        $reference = $this->getReference($name);
        if (!is_a($reference, $class)) {
            throw new \RuntimeException(sprintf('"%s" is not a "%s"', $name, $class));
        }

        return $reference;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    protected abstract function getReference($name);
}

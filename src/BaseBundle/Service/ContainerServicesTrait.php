<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

trait ContainerServicesTrait
{
    /**
     * @return UserService
     */
    public function getUserService()
    {
        return $this->getContainer()->get('ddr.symfonyangularrestexample.service.user');
    }

    /**
     * @return BlogPostService
     */
    public function getBlogPostService()
    {
        return $this->getContainer()->get('ddr.symfonyangularrestexample.service.blogpost');
    }

    /**
     * @return ContainerInterface
     */
    public abstract function getContainer();
}

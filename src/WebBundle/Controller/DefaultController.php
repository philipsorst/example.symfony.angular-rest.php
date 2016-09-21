<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\WebBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends BaseController
{
    public function indexAction()
    {
        $blogPosts = $this->getBlogPostService()->listBlogPosts();

        return $this->render(
            '@DdrSymfonyAngularRestExampleWeb/Default/index.html.twig',
            ['blogPosts' => $blogPosts]
        );
    }
}

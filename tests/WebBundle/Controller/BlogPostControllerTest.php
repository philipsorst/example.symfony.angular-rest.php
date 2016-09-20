<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\WebBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\BlogPosts;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogPostControllerTest extends AbstractControllerTest
{
    public function testDetailAction()
    {
        /** @var BlogPost $blogPost */
        $blogPost = $this->referenceRepository->getReference(BlogPosts::BLOG_POST_1);
        $this->client->request(Request::METHOD_GET, sprintf('/twig/blogposts/%s', $blogPost->getId()));
        $this->assertStatusCode(Response::HTTP_OK, $this->client);
    }

    /**
     * @return string[]
     */
    protected function getFixtureClasses()
    {
        return [BlogPosts::class];
    }
}

<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\WebBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\BlogPosts;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Comments;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;
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

    public function testDetailActionMissing()
    {
        $this->client->request(Request::METHOD_GET, sprintf('/twig/blogposts/666'));
        $this->assertStatusCode(Response::HTTP_NOT_FOUND, $this->client);
    }

    public function testEditAction()
    {
        /** @var BlogPost $blogPost */
        $blogPost = $this->referenceRepository->getReference(BlogPosts::BLOG_POST_1);
        $this->client->request(Request::METHOD_GET, sprintf('/twig/blogposts/%s/edit', $blogPost->getId()));
        $this->assertLoginRequired();
    }

    public function testDeleteAction()
    {
        /** @var BlogPost $blogPost */
        $blogPost = $this->referenceRepository->getReference(BlogPosts::BLOG_POST_1);
        $this->client->request(Request::METHOD_GET, sprintf('/twig/blogposts/%s/delete', $blogPost->getId()));
        $this->assertLoginRequired();
    }

    public function testDeleteCommentAction()
    {
        /** @var Comment $comment */
        $comment = $this->referenceRepository->getReference(Comments::BLOG_POST_1_COMMENT_1);
        $this->client->request(Request::METHOD_GET, sprintf('/twig/comments/%s/delete', $comment->getId()));
        $this->assertLoginRequired();
    }

    /**
     * @return string[]
     */
    protected function getFixtureClasses()
    {
        return [BlogPosts::class, Comments::class];
    }
}

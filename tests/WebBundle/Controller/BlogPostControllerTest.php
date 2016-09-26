<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\WebBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\BlogPosts;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Comments;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Users;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogPostControllerTest extends AbstractControllerTest
{
    public function testCreateCommentAction()
    {
        $blogPost = $this->getBlogPostReference(BlogPosts::BLOG_POST_1);

        $crawler = $this->client->request(Request::METHOD_GET, sprintf('/twig/blogposts/%s', $blogPost->getId()));
        $this->assertStatusCode(Response::HTTP_OK, $this->client);
        $this->assertCount(0, $crawler->selectButton('Comment'));

        $this->logIn($this->getUserReference(Users::USER));

        $crawler = $this->client->request(Request::METHOD_GET, sprintf('/twig/blogposts/%s', $blogPost->getId()));
        $this->assertStatusCode(Response::HTTP_OK, $this->client);
        $form = $crawler->selectButton('Comment')->form();
        $this->client->submit(
            $form,
            [
                'comment[content]' => 'Test Comment Content'
            ]
        );
        $this->assertStatusCode(Response::HTTP_OK, $this->client);
    }

    public function testDetailActionMissing()
    {
        $this->client->request(Request::METHOD_GET, sprintf('/twig/blogposts/666'));
        $this->assertStatusCode(Response::HTTP_NOT_FOUND, $this->client);
    }

    public function testEditAction()
    {
        $blogPost = $this->getBlogPostReference(BlogPosts::BLOG_POST_1);
        $this->client->request(Request::METHOD_GET, sprintf('/twig/blogposts/%s/edit', $blogPost->getId()));
        $this->assertLoginRequired();

        $this->logIn($this->getUserReference(Users::USER));

        $this->client->request(Request::METHOD_GET, sprintf('/twig/blogposts/%s/edit', $blogPost->getId()));
        $this->assertStatusCode(Response::HTTP_OK, $this->client);
    }

    public function testDeleteAction()
    {
        $blogPost = $this->getBlogPostReference(BlogPosts::BLOG_POST_1);
        $this->client->request(Request::METHOD_GET, sprintf('/twig/blogposts/%s/delete', $blogPost->getId()));
        $this->assertLoginRequired();

        $this->logIn($this->getUserReference(Users::USER));

        $this->client->request(Request::METHOD_GET, sprintf('/twig/blogposts/%s/delete', $blogPost->getId()));
        $this->assertStatusCode(Response::HTTP_FOUND, $this->client);

        $this->client->request(Request::METHOD_GET, sprintf('/twig/blogposts/%s', $blogPost->getId()));
        $this->assertStatusCode(Response::HTTP_NOT_FOUND, $this->client);
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

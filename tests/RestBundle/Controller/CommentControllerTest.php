<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\ApiKeys;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\BlogPosts;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Comments;
use Symfony\Component\HttpFoundation\Response;

class CommentControllerTest extends RestControllerTestCase
{
    public function testCommentListAction()
    {
        $blogPost = $this->referenceRepository->getReference(BlogPosts::BLOG_POST_1);
        $url = sprintf('/rest/blogposts/%s/comments', $blogPost->getId());
        $response = $this->doGetRequest($url);
        $this->assertJsonResponse($response);
    }

    public function testCommentCreateAction()
    {
        $blogPost = $this->referenceRepository->getReference(BlogPosts::BLOG_POST_1);
        $apiKey = $this->referenceRepository->getReference(ApiKeys::USER_API_KEY);
        $url = sprintf('/rest/blogposts/%s/comments', $blogPost->getId());

        $response = $this->doPostRequest($url, ['content' => 'TestContent']);
        $this->assertJsonResponse($response, Response::HTTP_UNAUTHORIZED);

        $response = $this->doPostRequest($url, ['content' => 'TestContent'], $apiKey);
        $this->assertJsonResponse($response, Response::HTTP_CREATED);
    }

    public function testPostEmptyComment()
    {
        $blogPost = $this->referenceRepository->getReference(BlogPosts::BLOG_POST_1);
        $apiKey = $this->referenceRepository->getReference(ApiKeys::USER_API_KEY);
        $url = sprintf('/rest/blogposts/%s/comments', $blogPost->getId());
        $response = $this->doPostRequest($url, ['content' => ''], $apiKey);
        $content = $this->assertJsonResponse($response, Response::HTTP_BAD_REQUEST);
        $this->assertEquals('This value should not be blank.', $content['children']['content']['errors'][0]);
    }

    public function testCommentGetAction()
    {
        $blogPost = $this->referenceRepository->getReference(BlogPosts::BLOG_POST_1);
        $comment = $this->referenceRepository->getReference(Comments::BLOG_POST_1_COMMENT_1);
        $url = sprintf('/rest/blogposts/%s/comments/%s', $blogPost->getId(), $comment->getId());
        $response = $this->doGetRequest($url);
        $this->assertJsonResponse($response);
    }

    public function testCommentDeleteAction()
    {
        $blogPost = $this->referenceRepository->getReference(BlogPosts::BLOG_POST_1);
        $comment = $this->referenceRepository->getReference(Comments::BLOG_POST_1_COMMENT_2);
        $apiKey = $this->referenceRepository->getReference(ApiKeys::USER_API_KEY);
        $url = sprintf('/rest/blogposts/%s/comments/%s', $blogPost->getId(), $comment->getId());

        $response = $this->doDeleteRequest($url);
        $this->assertJsonResponse($response, Response::HTTP_UNAUTHORIZED);

        $response = $this->doDeleteRequest($url, $apiKey);
        $this->assertJsonResponse($response, Response::HTTP_NO_CONTENT);
    }

    /**
     * @return string[]
     */
    protected function getFixtureClasses()
    {
        return [Comments::class, ApiKeys::class];
    }
}

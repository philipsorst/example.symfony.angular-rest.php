<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\ApiKeys;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\BlogPosts;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Comments;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Users;
use Symfony\Component\HttpFoundation\Response;

class BlogPostControllerTest extends RestControllerTestCase
{
    public function testListBlogPosts()
    {
        $response = $this->doGetRequest('/rest/blogposts');
        $content = $this->assertJsonResponse($response, Response::HTTP_OK);
        $this->assertCount(2, $content);
        $blogPost2 = $this->getBlogPostReference(BlogPosts::BLOG_POST_2);
        $user = $this->getUserReference(Users::ADMIN);
        $expectedContent = [
            'id'           => $blogPost2->getId(),
            'title'        => $blogPost2->getTitle(),
            'content'      => $blogPost2->getContent(),
            'date'         => $blogPost2->getDate()->format('Y-m-d\TH:i:sO'),
            'num_comments' => $blogPost2->getNumComments(),
            'author'       => [
                'id'       => $user->getId(),
                'username' => $user->getUsername()
            ]
        ];

        $this->assertEquals($expectedContent, $content[1]);
    }

    public function testGestBlogPost()
    {
        $response = $this->doGetRequest('/rest/blogposts/1');
        $content = $this->assertJsonResponse($response, Response::HTTP_OK);
        $blogPost = $this->getBlogPostReference(BlogPosts::BLOG_POST_1);
        $user = $this->getUserReference('user');
        $expectedContent = [
            'id'           => $blogPost->getId(),
            'title'        => $blogPost->getTitle(),
            'content'      => $blogPost->getContent(),
            'date'         => $blogPost->getDate()->format('Y-m-d\TH:i:sO'),
            'num_comments' => $blogPost->getNumComments(),
            'author'       => [
                'id'       => $user->getId(),
                'username' => $user->getUsername()
            ]
        ];

        $this->assertEquals($expectedContent, $content);
    }

    public function testCreateBlogPost()
    {
        $response = $this->doPostRequest(
            '/rest/blogposts',
            ['title' => 'TestTitle', 'content' => 'TestContent'],
            $this->getApiKeyReference(ApiKeys::ADMIN_API_KEY)
        );
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals('/rest/blogposts/3', $response->headers->get('location'));
    }

    public function testCreateEmptyBlogPost()
    {
        /* Content is missing */
        $response = $this->doPostRequest(
            '/rest/blogposts',
            [],
            $this->getApiKeyReference(ApiKeys::ADMIN_API_KEY)
        );
        $content = $this->assertJsonResponse($response, Response::HTTP_BAD_REQUEST);
        $this->assertEquals('Validation Failed', $content['message']);
        $this->assertEquals('This value should not be blank.', $content['errors']['children']['title']['errors'][0]);
        $this->assertEquals('This value should not be blank.', $content['errors']['children']['content']['errors'][0]);
    }

    public function testCreateInvalidBlogPost()
    {
        /* Content is missing */
        $response = $this->doPostRequest(
            '/rest/blogposts',
            ['title' => 'TestTitle'],
            $this->getApiKeyReference(ApiKeys::ADMIN_API_KEY)
        );
        $content = $this->assertJsonResponse($response, Response::HTTP_BAD_REQUEST);
        $this->assertEquals('Validation Failed', $content['message']);
        $this->assertEquals('This value should not be blank.', $content['errors']['children']['content']['errors'][0]);
    }

    public function testGetMissingBlogPost()
    {
        $response = $this->doGetRequest('/rest/blogposts/666');
        $this->assertJsonResponse($response, Response::HTTP_NOT_FOUND);
    }

    /**
     * @return string[]
     */
    protected function getFixtureClasses()
    {
        return [
            Users::class,
            BlogPosts::class,
            Comments::class,
            ApiKeys::class
        ];
    }
}

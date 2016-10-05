<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Dontdrinkandroot\SymfonyAngularRestExample\AbstractIntegrationTest;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\BlogPosts;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Comments;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM\Users;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Exception\NoResultException;

class DoctrineBlogPostServiceTest extends AbstractIntegrationTest
{
    public function testSaveComment()
    {
        $blogPost = $this->getBlogPostReference(BlogPosts::BLOG_POST_2);
        $user = $this->getUserReference(Users::DUMMY);

        $comment = new Comment($blogPost, $user, 'ExampleContent');

        $blogPostService = $this->getBlogPostService();
        $savedComment = $blogPostService->saveComment($comment);

        $this->assertNotNull($blogPostService->loadComment($savedComment->getId()));
        $this->assertEquals(2, $blogPostService->loadBlogPost($blogPost->getId())->getNumComments());
    }

    public function testDeleteComment()
    {
        $comment = $this->getCommentReference(Comments::BLOG_POST_2_COMMENT_1);
        $commentId = $comment->getId();
        $blogPost = $comment->getBlogPost();

        $blogPostService = $this->getBlogPostService();
        $blogPostService->deleteComment($comment);

        try {
            $blogPostService->loadComment($commentId);
            $this->fail('NoResultException expected');
        } catch (NoResultException $e) {
            /* Expected */
        }

        $this->assertEquals(
            0,
            $blogPostService->loadBlogPost($blogPost->getId())->getNumComments()
        );
    }

    /**
     * @return string[]
     */
    protected function getFixtureClasses()
    {
        return [Comments::class];
    }
}

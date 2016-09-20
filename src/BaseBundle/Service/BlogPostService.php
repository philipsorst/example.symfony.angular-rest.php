<?php


namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;

interface BlogPostService
{

    /**
     * @return BlogPost[]
     */
    public function listBlogPosts();

    /**
     * @param int $id
     *
     * @return BlogPost
     */
    public function getBlogPost($id);

    /**
     * @param BlogPost $blogPost
     */
    public function deleteBlogPost(BlogPost $blogPost);

    /**
     * @param BlogPost $blogPost
     *
     * @return BlogPost
     */
    public function saveBlogPost($blogPost);

    /**
     * @param int $id
     *
     * @return Comment[]
     */
    public function findComments($id);

    /**
     * @param $commentId
     *
     * @return Comment
     */
    public function getComment($commentId);

    /**
     * @param Comment $comment
     */
    public function deleteComment(Comment $comment);

    /**
     * @param Comment $comment
     *
     * @return Comment
     */
    public function saveComment($comment);
}

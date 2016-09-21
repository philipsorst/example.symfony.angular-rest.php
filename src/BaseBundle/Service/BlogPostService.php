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
    public function loadBlogPost($id);

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
     * @param $commentId
     *
     * @return Comment
     */
    public function loadComment($commentId);

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

    /**
     * @param BlogPost|int $blogPost
     *
     * @return Comment[]
     */
    public function listCommentsByBlogPost($blogPost);
}

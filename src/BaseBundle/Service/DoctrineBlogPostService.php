<?php


namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Exception\NoResultException;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository\BlogPostRepository;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository\CommentRepository;

class DoctrineBlogPostService implements BlogPostService
{

    /**
     * @var BlogPostRepository
     */
    protected $blogPostRepository;

    /**
     * @var CommentRepository
     */
    protected $commentRepository;

    public function __construct(BlogPostRepository $blogPostRepository, CommentRepository $commentRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @return BlogPost[]
     */
    public function listBlogPosts()
    {
        $blogPosts = $this->blogPostRepository->findBy([], ['date' => 'DESC']);

        return $blogPosts;
    }

    /**
     * @param int $id
     *
     * @return BlogPost
     *
     * @throws NoResultException
     */
    public function getBlogPost($id)
    {
        /** @var BlogPost|null $blogPost */
        $blogPost = $this->blogPostRepository->find($id);
        if (null === $blogPost) {
            throw new NoResultException();
        }

        return $blogPost;
    }

    /**
     * @param BlogPost $blogPost
     */
    public function deleteBlogPost(BlogPost $blogPost)
    {
        $this->blogPostRepository->remove($blogPost);
    }

    /**
     * @param BlogPost $blogPost
     *
     * @return BlogPost
     */
    public function saveBlogPost($blogPost)
    {
        return $this->blogPostRepository->save($blogPost);
    }

    /**
     * @param int $id
     *
     * @return Comment[]
     */
    public function findComments($id)
    {
        $comments = $this->commentRepository->findBy(['blogPost' => $id], ['date' => 'DESC']);

        return $comments;
    }

    /**
     * @param int $commentId
     *
     * @return Comment
     *
     * @throws NoResultException
     */
    public function getComment($commentId)
    {
        /** @var Comment|null $comment */
        $comment = $this->commentRepository->find($commentId);
        if (null === $comment) {
            throw new NoResultException();
        }

        return $comment;
    }

    /**
     * @param Comment $comment
     */
    public function deleteComment(Comment $comment)
    {
        $this->commentRepository->remove($comment);
    }

    /**
     * @param Comment $comment
     *
     * @return Comment
     */
    public function saveComment($comment)
    {
        return $this->commentRepository->save($comment);
    }
}

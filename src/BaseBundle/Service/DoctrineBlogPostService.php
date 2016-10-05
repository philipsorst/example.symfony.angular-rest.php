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
    public function loadBlogPost($id)
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
     * @param BlogPost $blogPost
     *
     * @return Comment[]
     */
    public function listCommentsByBlogPost($blogPost)
    {
        return $this->commentRepository->findBy(['blogPost' => $blogPost], ['date' => 'desc']);
    }

    /**
     * @param int $commentId
     *
     * @return Comment
     *
     * @throws NoResultException
     */
    public function loadComment($commentId)
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
        $this->updateNumComments($comment->getBlogPost());
    }

    /**
     * @param Comment $comment
     *
     * @return Comment
     */
    public function saveComment(Comment $comment)
    {
        $comment->setDate(new \DateTime());
        $savedComment = $this->commentRepository->save($comment);

        $this->updateNumComments($comment->getBlogPost());

        return $savedComment;
    }

    protected function updateNumComments(BlogPost $blogPost)
    {
        $numComments = $this->commentRepository->findCountByBlogPost($blogPost);
        $blogPost->setNumComments($numComments);

        $this->blogPostRepository->save($blogPost);
    }
}

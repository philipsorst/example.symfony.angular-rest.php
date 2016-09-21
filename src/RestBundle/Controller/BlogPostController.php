<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Form\BlogPostType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class BlogPostController extends RestBaseController
{

    /**
     * @Rest\Get("")
     *
     * @return Response
     */
    public function listBlogPostsAction()
    {
        $blogPosts = $this->getBlogPostService()->listBlogPosts();

        $view = $this->view($blogPosts);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/{id}", requirements={"id" = "\d+"})
     *
     * @param int $id
     *
     * @return Response
     */
    public function getBlogPostAction($id)
    {
        $blogPost = $this->getBlogPostService()->loadBlogPost($id);

        $view = $this->view($blogPost);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createBlogPostAction(Request $request)
    {
        $form = $this->createForm(BlogPostType::class, new BlogPost());
        $form->handleRequest($request);
        if ($form->isValid()) {
            /** @var BlogPost $blogPost */
            $blogPost = $form->getData();
            $blogPost->setAuthor($this->getUser());
            $blogPost->setDate(new \DateTime());
            $blogPost = $this->getBlogPostService()->saveBlogPost($blogPost);

            $view = $this->view($blogPost, Response::HTTP_CREATED);
            $view->setHeader(
                'Location',
                $this->generateUrl(
                    'ddr_example_rest_blogpost_get_blog_post',
                    ['id' => $blogPost->getId()],
                    true
                )
            );

            return $this->handleView($view);
        }

        return $this->handleView($this->view($form, Response::HTTP_BAD_REQUEST));
    }

    /**
     * @Rest\Put("/{id}", requirements={"id" = "\d+"})
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function updateBlogPostAction(Request $request, $id)
    {
        $blogPostService = $this->getBlogPostService();
        $blogPost = $blogPostService->loadBlogPost($id);
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if (!$currentUser->hasRole('ROLE_ADMIN') && $currentUser->getId() !== $blogPost->getAuthor()->getId()) {
            throw $this->createAccessDeniedException('Cannot delete news entries of other users');
        }

        /** @var BlogPost $blogPost */
        $blogPost = $this->unserializeRequestContent($request, get_class(new BlogPost()));

        $errors = $this->validate($blogPost);
        if (count($errors) > 0) {
            $view = $this->view($errors, Response::HTTP_BAD_REQUEST);

            return $this->handleView($view);
        }

        $blogPost->setAuthor($blogPost->getAuthor());
        $blogPost = $blogPostService->saveBlogPost($blogPost);

        $view = $this->view($blogPost);

        return $this->handleView($view);
    }

    /**
     * @Rest\Delete("/{id}", requirements={"id" = "\d+"})
     *
     * @param int $id
     *
     * @return Response
     */
    public function deleteBlogPostAction($id)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $blogPostService = $this->getBlogPostService();
        $blogPost = $blogPostService->loadBlogPost($id);

        if (!$currentUser->hasRole('ROLE_ADMIN') && $currentUser->getId() !== $blogPost->getAuthor()->getId()) {
            throw new AccessDeniedHttpException('Cannot delete blog posts of other users');
        }

        $blogPostService->deleteBlogPost($blogPost);

        $view = $this->view(null, Response::HTTP_NO_CONTENT);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/{id}/comments", requirements={"id" = "\d+"})
     *
     * @param int $id
     *
     * @return Response
     */
    public function listCommentsAction($id)
    {
        $blogPostService = $this->getBlogPostService();
        $comments = $blogPostService->listCommentsByBlogPost($id);

        $view = $this->view($comments);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/{blogPostId}/comments/{commentId}", requirements={"blogPostId" = "\d+", "commentId" = "\d+"})
     *
     * @param int $blogPostId
     * @param int $commentId
     *
     * @return Response
     */
    public function getCommentAction($blogPostId, $commentId)
    {
        $blogPostService = $this->getBlogPostService();
        $comments = $blogPostService->loadComment($commentId);

        $view = $this->view($comments);

        return $this->handleView($view);
    }

    /**
     * @Rest\Delete("/{blogPostId}/comments/{commentId}", requirements={"blogPostId" = "\d+", "commentId" = "\d+"})
     *
     * @param int $blogPostId
     * @param int $commentId
     *
     * @return Response
     */
    public function deleteCommentAction($blogPostId, $commentId)
    {
        $currentUser = $this->getUser();
        $blogPostService = $this->getBlogPostService();

        $comment = $blogPostService->loadComment($commentId);

        if (!$currentUser->hasRole('ROLE_ADMIN') && $currentUser->getId() !== $comment->getAuthor()->getId()) {
            throw new AccessDeniedHttpException('Cannot delete comment of other users');
        }

        $comments = $blogPostService->deleteComment($comment);

        $view = $this->view($comments, Response::HTTP_NO_CONTENT);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/{id}/comments", requirements={"id" = "\d+"})
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function createCommentAction(Request $request, $id)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $blogPostService = $this->getBlogPostService();
        $blogPost = $blogPostService->loadBlogPost($id);

        /** @var Comment $comment */
        $comment = $this->unserializeRequestContent($request, get_class(new Comment()));

        $errors = $this->validate($comment);
        if (count($errors) > 0) {
            $view = $this->view($errors, Response::HTTP_BAD_REQUEST);

            return $this->handleView($view);
        }

        $comment->setAuthor($this->getUser());
        $comment->setDate(new \DateTime());
        $comment->setBlogPost($blogPost);
        $comment = $this->getBlogPostService()->saveComment($comment);

        $view = $this->view($comment, Response::HTTP_CREATED);

        $view->setHeader(
            'Location',
            $this->generateUrl(
                'ddr_example_rest_blogpost_get_comment',
                ['blogPostId' => $id, 'commentId' => $comment->getId()],
                true
            )
        );

        return $this->handleView($view);
    }
}

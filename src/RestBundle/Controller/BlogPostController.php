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
    public function getBlogpostsAction()
    {
        return $this->view($this->getBlogPostService()->listBlogPosts());
    }

    public function getBlogpostAction($id)
    {
        return $this->view($this->getBlogPostService()->loadBlogPost($id));
    }

    public function postBlogpostAction(Request $request)
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
                    'ddr_example_rest_get_blogpost',
                    ['id' => $blogPost->getId()],
                    true
                )
            );

            return $view;
        }

        return $this->view($form);
    }

    public function putBlogpostAction(Request $request, $id)
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
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        $blogPost->setAuthor($blogPost->getAuthor());
        $blogPost = $blogPostService->saveBlogPost($blogPost);

        return $this->view($blogPost);
    }

    public function deleteBlogpostAction($id)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $blogPostService = $this->getBlogPostService();
        $blogPost = $blogPostService->loadBlogPost($id);

        if (!$currentUser->hasRole('ROLE_ADMIN') && $currentUser->getId() !== $blogPost->getAuthor()->getId()) {
            throw new AccessDeniedHttpException('Cannot delete blog posts of other users');
        }

        $blogPostService->deleteBlogPost($blogPost);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    public function getBlogpostCommentsAction($blogPostId)
    {
        return $this->view($this->getBlogPostService()->listCommentsByBlogPost($blogPostId));
    }

    public function getBlogpostCommentAction($blogPostId, $commentId)
    {
        return $this->view($this->getBlogPostService()->loadComment($commentId));
    }

    public function deleteBlogpostCommentAction($blogPostId, $commentId)
    {
        $currentUser = $this->getUser();
        $blogPostService = $this->getBlogPostService();

        $comment = $blogPostService->loadComment($commentId);

        if (!$currentUser->hasRole('ROLE_ADMIN') && $currentUser->getId() !== $comment->getAuthor()->getId()) {
            throw new AccessDeniedHttpException('Cannot delete comment of other users');
        }

        $blogPostService->deleteComment($comment);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    public function postBlogpostCommentsAction(Request $request, $blogPostId)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $blogPostService = $this->getBlogPostService();
        $blogPost = $blogPostService->loadBlogPost($blogPostId);

        /** @var Comment $comment */
        $comment = $this->unserializeRequestContent($request, get_class(new Comment()));

        $errors = $this->validate($comment);
        if (count($errors) > 0) {
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        $comment->setAuthor($this->getUser());
        $comment->setDate(new \DateTime());
        $comment->setBlogPost($blogPost);
        $comment = $this->getBlogPostService()->saveComment($comment);

        $view = $this->view($comment, Response::HTTP_CREATED);

        $view->setHeader(
            'Location',
            $this->generateUrl(
                'ddr_example_rest_get_blogpost_comments',
                ['blogPostId' => $blogPostId, 'commentId' => $comment->getId()],
                true
            )
        );

        return $view;
    }
}

<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Form\BlogPostType;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Form\CommentType;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Security\BlogPostVoter;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Security\CommentVoter;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $form = $this->createAndHandleForm($request, BlogPostType::class);
        if ($form->isValid()) {
            /** @var BlogPost $blogPost */
            $blogPost = $form->getData();
            $blogPost->setAuthor($this->getUser());
            $blogPost->setDate(new \DateTime());
            $blogPost = $this->getBlogPostService()->saveBlogPost($blogPost);

            $view = $this->view($blogPost, Response::HTTP_CREATED);
            $view->setLocation(
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

        $form = $this->createAndHandleForm($request, BlogPostType::class, $blogPost, ['method' => Request::METHOD_PUT]);
        if ($form->isValid()) {
            /** @var BlogPost $blogPost */
            $blogPost = $form->getData();
            $this->denyAccessUnlessGranted(BlogPostVoter::EDIT, $blogPost);
            $blogPost = $this->getBlogPostService()->saveBlogPost($blogPost);

            return $this->view($blogPost);
        }

        return $this->view($form);
    }

    public function deleteBlogpostAction($id)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $blogPostService = $this->getBlogPostService();
        $blogPost = $blogPostService->loadBlogPost($id);
        $this->denyAccessUnlessGranted(BlogPostVoter::DELETE, $blogPost);
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
        $blogPostService = $this->getBlogPostService();
        $comment = $blogPostService->loadComment($commentId);
        $this->denyAccessUnlessGranted(CommentVoter::DELETE, $comment);
        $blogPostService->deleteComment($comment);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    public function postBlogpostCommentsAction(Request $request, $blogPostId)
    {
        $form = $this->createAndHandleForm($request, CommentType::class);
        if ($form->isValid()) {
            $blogPost = $this->getBlogPostService()->loadBlogPost($blogPostId);
            /** @var Comment $comment */
            $comment = $form->getData();
            $comment->setAuthor($this->getUser());
            $comment->setBlogPost($blogPost);
            $view = $this->view($this->getBlogPostService()->saveComment($comment), Response::HTTP_CREATED);
            $view->setLocation(
                $this->generateUrl(
                    'ddr_example_rest_get_blogpost_comments',
                    ['blogPostId' => $blogPostId, 'commentId' => $comment->getId()],
                    true
                )
            );

            return $view;
        }

        return $this->view($form);
    }
}

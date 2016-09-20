<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\WebBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Form\BlogPostType;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Form\CommentType;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BlogPostController extends Controller
{
    public function detailAction(Request $request, $id)
    {
        $blogPost = $this->loadBlogPost($id);
        $commentRepository = $this->getDoctrine()->getRepository(Comment::class);

        $commentForm = $this->createForm(CommentType::class);
        $commentForm->handleRequest($request);
        if ($commentForm->isValid()) {
            if (!$this->isGranted('ROLE_USER')) {
                throw new AccessDeniedException();
            }
            /** @var Comment $comment */
            $comment = $commentForm->getData();
            $comment->setBlogPost($blogPost);
            $comment->setAuthor($this->getUser());
            $comment->setDate(new \DateTime());
            $commentRepository->save($comment);
        }

        $comments = $commentRepository->findBy(['blogPost' => $blogPost], ['date' => 'desc']);

        return $this->render(
            '@DdrSymfonyAngularRestExampleWeb/BlogPost/detail.html.twig',
            ['blogPost' => $blogPost, 'comments' => $comments, 'commentForm' => $commentForm->createView()]
        );
    }

    public function editAction(Request $request, $id)
    {
        $blogPostRepository = $this->getDoctrine()->getRepository(BlogPost::class);
        $blogPost = null;
        if ('create' === $id) {
            $blogPost = new BlogPost();
            $blogPost->setAuthor($this->getUser());
        } else {
            $blogPost = $this->loadBlogPost($id, $blogPostRepository);
            if (!$this->isGranted('ROLE_ADMIN') || !$blogPost->getAuthor()->getId() === $this->getUser()->getId()) {
                throw new AccessDeniedException();
            }
        }

        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);
        if ($form->isValid()) {
            /** @var BlogPost $blogPost */
            $blogPost = $form->getData();
            $blogPost->setDate(new \DateTime());
            $blogPostRepository->save($blogPost);

            return $this->redirectToRoute('ddr_example_web_index');
        }

        return $this->render(
            '@DdrSymfonyAngularRestExampleWeb/BlogPost/edit.html.twig',
            ['form' => $form->createView(), 'blogPost' => $blogPost]
        );
    }

    public function deleteAction($id)
    {
        $blogPostRepository = $this->getDoctrine()->getRepository(BlogPost::class);
        $blogPost = $this->loadBlogPost($id, $blogPostRepository);

        if (!$this->isGranted('ROLE_ADMIN') || !$blogPost->getAuthor()->getId() === $this->getUser()->getId()) {
            throw new AccessDeniedException();
        }

        $blogPostRepository->remove($blogPost);

        return $this->redirectToRoute('ddr_example_web_index');
    }

    public function deleteCommentAction($id)
    {
        $commentRepository = $this->getDoctrine()->getRepository(Comment::class);
        $comment = $commentRepository->findOneBy(['id' => $id]);
        if (null == $comment) {
            throw new NotFoundHttpException();
        }

        if (!$this->isGranted('ROLE_ADMIN') || !$comment->getAuthor()->getId() === $this->getUser()->getId()) {
            throw new AccessDeniedException();
        }

        $commentRepository->remove($comment);

        return $this->redirectToRoute(
            'ddr_example_web_blogpost_detail',
            ['id' => $comment->getBlogPost()->getId()]
        );
    }

    /**
     * @param int                $id
     * @param BlogPostRepository $blogPostRepository
     *
     * @return BlogPost
     */
    public function loadBlogPost($id, $blogPostRepository = null)
    {
        if (null == $blogPostRepository) {
            $blogPostRepository = $this->getDoctrine()->getRepository(BlogPost::class);
        }

        /** @var BlogPost|null $blogPost */
        $blogPost = $blogPostRepository->findOneBy(['id' => $id]);
        if (null == $blogPost) {
            throw new NotFoundHttpException();
        }

        return $blogPost;
    }
}

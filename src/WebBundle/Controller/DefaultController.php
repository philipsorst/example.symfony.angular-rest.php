<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\WebBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $blogPostRepository = $this->getDoctrine()->getRepository(BlogPost::class);
        $blogPosts = $blogPostRepository->findBy([], ['date' => 'desc']);

        return $this->render(
            '@DdrSymfonyAngularRestExampleWeb/Default/index.html.twig',
            ['blogPosts' => $blogPosts]
        );
    }
}

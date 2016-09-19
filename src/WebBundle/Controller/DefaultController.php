<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\WebBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $newsEntryRepository = $this->getDoctrine()->getRepository(NewsEntry::class);
        $newsEntries = $newsEntryRepository->findBy([], ['date' => 'desc']);

        return $this->render(
            '@DdrSymfonyAngularRestExampleWeb/Default/index.html.twig',
            ['newsEntries' => $newsEntries]
        );
    }
}

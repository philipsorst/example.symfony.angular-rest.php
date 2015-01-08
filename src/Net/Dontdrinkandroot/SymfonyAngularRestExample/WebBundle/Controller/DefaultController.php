<?php

namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function angularAction()
    {
        return $this->render('DdrSymfonyAngularRestExampleWebBundle:Default:angular.html.twig');
    }
}

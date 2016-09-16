<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\Angular1Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DdrSymfonyAngularRestExampleAngular1Bundle:Default:index.html.twig');
    }
}

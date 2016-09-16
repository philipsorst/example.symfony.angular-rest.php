<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\Angular2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DdrSymfonyAngularRestExampleAngular2Bundle:Default:index.html.twig');
    }
}

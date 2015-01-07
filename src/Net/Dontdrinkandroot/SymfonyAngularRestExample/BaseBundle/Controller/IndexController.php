<?php

namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{

    public function indexAction()
    {
        return new Response('Hellp World');
    }
}
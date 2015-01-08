<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service\NewsEntryService;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service\UserService;

class RestBaseController extends FOSRestController
{

    /**
     * @return NewsEntryService
     */
    protected function getNewsEntryService()
    {
        return $this->get('ddr.symfonyangularrestexample.service.newsentry');
    }

    /**
     * @return UserService
     */
    protected function getUserService()
    {
        return $this->get('ddr.symfonyangularrestexample.service.user');
    }
} 
<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\RouteResource;

class UserController extends RestBaseController
{

    /**
     * @Get("/")
     */
    public function listUsersAction()
    {
    }

    /**
     * @Get("/{id}")
     *
     * @param integer $id
     */
    public function getUserAction($id)
    {
    }
}
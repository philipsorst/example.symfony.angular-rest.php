<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Response;

class UserController extends RestBaseController
{

    /**
     * @Get("/")
     *
     * @return Response
     */
    public function listUsersAction()
    {
        $users = $this->getUserService()->listUsers();

        $view = $this->view($users);

        return $this->handleView($view);
    }

    /**
     * @Get("/{id}")
     *
     * @param integer $id
     *
     * @return Response
     */
    public function getUserAction($id)
    {
        $user = $this->getUserService()->getUser($id);

        $view = $this->view($user);

        return $this->handleView($view);
    }
}
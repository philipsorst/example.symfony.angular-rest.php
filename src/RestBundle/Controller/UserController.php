<?php


namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Model\UserCredentials;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends RestBaseController
{

    /**
     * @Rest\Get("")
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
     * @Rest\Get("/{id}")
     *
     * @param int|string $id
     *
     * @return Response
     *
     * @throws \InvalidArgumentException
     */
    public function getUserAction($id)
    {
        if (is_numeric($id)) {
            $user = $this->getUserService()->getUser($id);
        } else {
            if ($id === 'me') {
                $user = $this->getUser();
            } else {
                throw new \InvalidArgumentException("Unknown identifier '$id'. Can be 'me' or an id");
            }
        }

        $view = $this->view($user);
        $view->getContext()->setGroups(['Default', 'UserRoles']);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/createapikey")
     *
     * @param Request $request
     */
    public function createApiKeyAction(Request $request)
    {
        /** @var UserCredentials $credentials */
        $credentials = $this->serializeRequestContent($request, get_class(new UserCredentials()));
        $apiKey = $this->getUserService()->createApiKey($credentials->getUsername(), $credentials->getPassword());

        $view = $this->view($apiKey, Response::HTTP_CREATED);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/invalidateapikey")
     *
     * @param Request $request
     */
    public function invalidateApiKeyAction(Request $request)
    {
        //TODO: implement
    }
}

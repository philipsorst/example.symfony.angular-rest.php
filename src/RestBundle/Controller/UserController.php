<?php


namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Form\UserCredentialsType;
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
     * @Rest\Post("/createapikey")
     *
     * @param Request $request
     */
    public function createApiKeyAction(Request $request)
    {
        $form = $this->createAndHandleForm($request, UserCredentialsType::class);
        if ($form->isValid()) {
            /** @var UserCredentials $credentials */
            $credentials = $form->getData();
            $apiKey = $this->getUserService()->createApiKey($credentials->getUsername(), $credentials->getPassword());

            return $this->view($apiKey, Response::HTTP_CREATED);
        }

        return $this->view($form);
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
            $user = $this->getUserService()->loadUser($id);
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
     * @Rest\Post("/invalidateapikey")
     *
     * @param Request $request
     */
    public function invalidateApiKeyAction(Request $request)
    {
        //TODO: implement
    }
}

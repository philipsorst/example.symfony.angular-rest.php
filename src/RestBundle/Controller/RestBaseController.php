<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service\BlogPostService;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service\UserService;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class RestBaseController extends FOSRestController
{

    /**
     * @return BlogPostService
     */
    protected function getBlogPostService()
    {
        return $this->get('ddr.symfonyangularrestexample.service.blogpost');
    }

    /**
     * @return UserService
     */
    protected function getUserService()
    {
        return $this->get('ddr.symfonyangularrestexample.service.user');
    }

    /**
     * @deprecated Use createAndHandleForm instead.
     */
    protected function createForm($type, $data = null, array $options = array())
    {
        if ($this->isGranted('ROLE_REST_API')) {
            /* We want a form with no name in the REST API, as the content is not prefixed with the name */
            return $this->container->get('form.factory')->createNamed('', $type, $data, $options);
        }

        return parent::createForm($type, $data, $options);
    }

    protected function createAndHandleForm(Request $request, $type, $data = null, array $options = [])
    {
        $form = null;
        if ('json' === $request->getRequestFormat()) {
            /* We want a form with no name in the REST API, as the content is not prefixed with the name */
            $form = $this->container->get('form.factory')->createNamed('', $type, $data, $options);
        } else {
            $form = parent::createForm($type, $data, $options);
        }
        $form->handleRequest($request);

        return $form;
    }
}

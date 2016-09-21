<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service\ContainerServicesTrait;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class RestBaseController extends FOSRestController
{
    use ContainerServicesTrait;

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

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}

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
            /* We want a form with no name in the JSON REST API, as the content is not prefixed with the form name */
            $form = $this->container->get('form.factory')->createNamed('', $type, $data, $options);
            /* Forms without a name are not submitted automatically if the data was empty. We want to enforce validation. */
            if (!$form->isSubmitted()) {
                $form->submit([]);
            }
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

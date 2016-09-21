<?php


namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service\BlogPostService;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service\UserService;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

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
     * @param Request $request
     * @param string  $type
     *
     * @return mixed
     */
    protected function unserializeRequestContent(Request $request, $type)
    {
        /** @var Serializer $serializer */
        $serializer = $this->get('jms_serializer');
        $content = $request->getContent();
        $object = $serializer->deserialize($content, $type, $request->getContentType());

        return $object;
    }

    /**
     * @param mixed $object
     *
     * @return ConstraintViolationListInterface
     */
    protected function validate($object)
    {
        $validator = $this->get('validator');
        $errors = $validator->validate($object);

        return $errors;
    }

    protected function createForm($type, $data = null, array $options = array())
    {
        if ($this->isGranted('ROLE_REST_API')) {
            /* We want a form with no name in the REST API, as the content is not prefixed with the name */
            return $this->container->get('form.factory')->createNamed('', $type, $data, $options);
        }

        return parent::createForm($type, $data, $options);
    }
}

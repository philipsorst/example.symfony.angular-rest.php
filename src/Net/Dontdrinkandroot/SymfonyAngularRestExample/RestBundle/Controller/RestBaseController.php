<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\Serializer;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service\NewsEntryService;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

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

    /**
     * @param Request $request
     * @param string  $type
     *
     * @return mixed
     */
    protected function deserializeJson(Request $request, $type)
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
    protected function validate($object) {
        $validator = $this->get('validator');
        $errors = $validator->validate($object);

        return $errors;
    }
} 
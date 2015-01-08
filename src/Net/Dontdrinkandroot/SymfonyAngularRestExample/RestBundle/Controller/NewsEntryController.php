<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\RouteResource;

class NewsEntryController extends RestBaseController
{

    /**
     * @Get("/")
     */
    public function listNewsEntriesAction()
    {
    }

    /**
     * @Get("/{id}")
     */
    public function getNewsEntryAction($id)
    {
    }

    /**
     * @Post("/")
     */
    public function createNewsEntryAction()
    {
    }

    /**
     * @Put("/{id}")
     */
    public function updateNewsEntryAction($id)
    {
    }

    /**
     * @Delete("/{id}")
     */
    public function deleteNewsEntryAction($id)
    {
    }
}
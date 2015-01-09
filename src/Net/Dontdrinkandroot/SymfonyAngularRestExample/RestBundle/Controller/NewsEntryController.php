<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class NewsEntryController extends RestBaseController
{

    /**
     * @Get("/")
     *
     * @return Response
     */
    public function listNewsEntriesAction()
    {
        $newsEntries = $this->getNewsEntryService()->listNewsEntries();

        $view = $this->view($newsEntries);

        return $this->handleView($view);
    }

    /**
     * @Get("/{id}")
     *
     * @param integer $id
     *
     * @return Response
     */
    public function getNewsEntryAction($id)
    {
        $newsEntry = $this->getNewsEntryService()->getNewsEntry($id);

        $view = $this->view($newsEntry);

        return $this->handleView($view);
    }

    /**
     * @Post("/")
     *
     * @return Response
     */
    public function createNewsEntryAction()
    {
        // TODO: implement
    }

    /**
     * @Put("/{id}")
     *
     * @param integer $id
     *
     * @return Response
     */
    public function updateNewsEntryAction($id)
    {
        // TODO: implement
    }

    /**
     * @Delete("/{id}")
     *
     * @param integer $id
     *
     * @return Response
     */
    public function deleteNewsEntryAction($id)
    {
        $newsEntryService = $this->getNewsEntryService();
        $newsEntry = $newsEntryService->getNewsEntry($id);
        $newsEntryService->deleteNewsEntry($newsEntry);

        $view = $this->view(null, 204);

        return $this->handleView($view);
    }
}
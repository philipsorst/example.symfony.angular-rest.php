<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\View\View;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsEntryController extends RestBaseController
{

    /**
     * @Get("")
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
     * @Post("")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createNewsEntryAction(Request $request)
    {
        /** @var NewsEntry $newsEntry */
        $newsEntry = $this->deserializeJson($request, get_class(new NewsEntry()));
        $newsEntry->setAuthor($this->getUser());
        $newsEntry->setDate(new \DateTime());
        $newsEntry = $this->getNewsEntryService()->saveNewsEntry($newsEntry);

        $view = $this->view($newsEntry, 201);

        $view->setHeader(
            'Location',
            $this->generateUrl(
                'ddr_symfony_angular_rest_example_rest_newsentry_get_news_entry',
                ['id' => $newsEntry->getId()],
                true
            )
        );

        return $this->handleView($view);
    }

    /**
     * @Put("/{id}")
     *
     * @param Request $request
     * @param integer $id
     *
     * @return Response
     */
    public function updateNewsEntryAction(Request $request, $id)
    {
        /** @var NewsEntry $newsEntry */
        $newsEntry = $this->deserializeJson($request, get_class(new NewsEntry()));
        $newsEntry->setAuthor($this->getUser());
        $newsEntry = $this->getNewsEntryService()->saveNewsEntry($newsEntry);

        $view = $this->view($newsEntry, 204);

        return $this->handleView($view);
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
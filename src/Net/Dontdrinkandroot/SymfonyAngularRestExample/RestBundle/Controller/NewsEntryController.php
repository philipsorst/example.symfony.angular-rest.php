<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\View\View;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

        $errors = $this->validate($newsEntry);
        if (count($errors) > 0) {
            $view = $this->view($errors, Response::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        $newsEntry->setAuthor($this->getUser());
        $newsEntry->setDate(new \DateTime());
        $newsEntry = $this->getNewsEntryService()->saveNewsEntry($newsEntry);

        $view = $this->view($newsEntry, Response::HTTP_CREATED);

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
        $newsEntryService = $this->getNewsEntryService();
        $newsEntry = $newsEntryService->getNewsEntry($id);
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if (!$currentUser->hasRole('ROLE_ADMIN') && $currentUser->getId() !== $newsEntry->getAuthor()->getId()) {
            throw $this->createAccessDeniedException('Cannot delete news entries of other users');
        }

        /** @var NewsEntry $newsEntry */
        $newsEntry = $this->deserializeJson($request, get_class(new NewsEntry()));

        $errors = $this->validate($newsEntry);
        if (count($errors) > 0) {
            $view = $this->view($errors, Response::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        $newsEntry->setAuthor($newsEntry->getAuthor());
        $newsEntry = $newsEntryService->saveNewsEntry($newsEntry);

        $view = $this->view($newsEntry);

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
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $newsEntryService = $this->getNewsEntryService();
        $newsEntry = $newsEntryService->getNewsEntry($id);

        if (!$currentUser->hasRole('ROLE_ADMIN') && $currentUser->getId() !== $newsEntry->getAuthor()->getId()) {
            throw new AccessDeniedHttpException('Cannot delete news entries of other users');
        }

        $newsEntryService->deleteNewsEntry($newsEntry);

        $view = $this->view(null, Response::HTTP_NO_CONTENT);

        return $this->handleView($view);
    }

    /**
     * @Get("/{id}/comments")
     *
     * @param integer $id
     *
     * @return Response
     */
    public function listCommentsAction($id)
    {
        $newsEntryService = $this->getNewsEntryService();
        $comments = $newsEntryService->findComments($id);

        $view = $this->view($comments);

        return $this->handleView($view);
    }

    /**
     * @Get("/{newsEntryId}/comments/{commentId}")
     *
     * @param integer $newsEntryId
     * @param integer $commentId
     *
     * @return Response
     */
    public function getCommentAction($newsEntryId, $commentId)
    {
        $newsEntryService = $this->getNewsEntryService();
        $comments = $newsEntryService->getComment($commentId);

        $view = $this->view($comments);

        return $this->handleView($view);
    }

    /**
     * @Delete("/{newsEntryId}/comments/{commentId}")
     *
     * @param integer $newsEntryId
     * @param integer $commentId
     *
     * @return Response
     */
    public function deleteCommentAction($newsEntryId, $commentId)
    {
        $currentUser = $this->getUser();
        $newsEntryService = $this->getNewsEntryService();

        $comment = $newsEntryService->getComment($commentId);

        if (!$currentUser->hasRole('ROLE_ADMIN') && $currentUser->getId() !== $comment->getAuthor()->getId()) {
            throw new AccessDeniedHttpException('Cannot delete comment of other users');
        }

        $comments = $newsEntryService->deleteComment($comment);

        $view = $this->view($comments, Response::HTTP_NO_CONTENT);

        return $this->handleView($view);
    }

    /**
     * @Post("/{id}/comments")
     *
     * @param Request $request
     * @param integer $id
     *
     * @return Response
     */
    public function createCommentAction(Request $request, $id)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $newsEntryService = $this->getNewsEntryService();
        $newsEntry = $newsEntryService->getNewsEntry($id);

        /** @var Comment $comment */
        $comment = $this->deserializeJson($request, get_class(new Comment()));

        $errors = $this->validate($comment);
        if (count($errors) > 0) {
            $view = $this->view($errors, Response::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        $comment->setAuthor($this->getUser());
        $comment->setDate(new \DateTime());
        $comment->setNewsEntry($newsEntry);
        $comment = $this->getNewsEntryService()->saveComment($comment);

        $view = $this->view($comment, Response::HTTP_CREATED);

        $view->setHeader(
            'Location',
            $this->generateUrl(
                'ddr_symfony_angular_rest_example_rest_newsentry_get_comment',
                ['newsEntryId' => $id, 'commentId' => $comment->getId()],
                true
            )
        );

        return $this->handleView($view);
    }
}
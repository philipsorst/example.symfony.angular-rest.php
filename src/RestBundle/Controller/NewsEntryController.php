<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Form\NewsEntryType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class NewsEntryController extends RestBaseController
{

    /**
     * @Rest\Get("")
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
     * @Rest\Get("/{id}", requirements={"id" = "\d+"})
     *
     * @param int $id
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
     * @Rest\Post("")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createNewsEntryAction(Request $request)
    {
        $form = $this->createForm(NewsEntryType::class, new NewsEntry());
        $form->handleRequest($request);
        if ($form->isValid()) {
            /** @var NewsEntry $newsEntry */
            $newsEntry = $form->getData();
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

        return $this->handleView($this->view($form, Response::HTTP_BAD_REQUEST));
    }

    /**
     * @Rest\Put("/{id}", requirements={"id" = "\d+"})
     *
     * @param Request $request
     * @param int     $id
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
        $newsEntry = $this->unserializeRequestContent($request, get_class(new NewsEntry()));

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
     * @Rest\Delete("/{id}", requirements={"id" = "\d+"})
     *
     * @param int $id
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
     * @Rest\Get("/{id}/comments", requirements={"id" = "\d+"})
     *
     * @param int $id
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
     * @Rest\Get("/{newsEntryId}/comments/{commentId}", requirements={"newsEntryId" = "\d+", "commentId" = "\d+"})
     *
     * @param int $newsEntryId
     * @param int $commentId
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
     * @Rest\Delete("/{newsEntryId}/comments/{commentId}", requirements={"newsEntryId" = "\d+", "commentId" = "\d+"})
     *
     * @param int $newsEntryId
     * @param int $commentId
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
     * @Rest\Post("/{id}/comments", requirements={"id" = "\d+"})
     *
     * @param Request $request
     * @param int     $id
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
        $comment = $this->unserializeRequestContent($request, get_class(new Comment()));

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

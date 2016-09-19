<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\WebBundle\Controller;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Form\CommentType;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Form\NewsEntryType;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository\CommentRepository;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository\NewsEntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class NewsEntryController extends Controller
{
    public function detailAction(Request $request, $id)
    {
        $newsEntry = $this->loadNewsEntry($id);
        $commentRepository = $this->getDoctrine()->getRepository(Comment::class);

        $commentForm = $this->createForm(CommentType::class);
        $commentForm->handleRequest($request);
        if ($commentForm->isValid()) {
            if (!$this->isGranted('ROLE_USER')) {
                throw new AccessDeniedException();
            }
            /** @var Comment $comment */
            $comment = $commentForm->getData();
            $comment->setNewsEntry($newsEntry);
            $comment->setAuthor($this->getUser());
            $comment->setDate(new \DateTime());
            $commentRepository->save($comment);
        }

        $comments = $commentRepository->findBy(['newsEntry' => $newsEntry], ['date' => 'desc']);

        return $this->render(
            '@DdrSymfonyAngularRestExampleWeb/NewsEntry/detail.html.twig',
            ['newsEntry' => $newsEntry, 'comments' => $comments, 'commentForm' => $commentForm->createView()]
        );
    }

    public function editAction(Request $request, $id)
    {
        $newsEntryRepository = $this->getDoctrine()->getRepository(NewsEntry::class);
        $newsEntry = null;
        if ('create' === $id) {
            $newsEntry = new NewsEntry();
            $newsEntry->setAuthor($this->getUser());
        } else {
            $newsEntry = $this->loadNewsEntry($id, $newsEntryRepository);
            if (!$this->isGranted('ROLE_ADMIN') || !$newsEntry->getAuthor()->getId() === $this->getUser()->getId()) {
                throw new AccessDeniedException();
            }
        }

        $form = $this->createForm(NewsEntryType::class, $newsEntry);
        $form->handleRequest($request);
        if ($form->isValid()) {
            /** @var NewsEntry $newsEntry */
            $newsEntry = $form->getData();
            $newsEntry->setDate(new \DateTime());
            $newsEntryRepository->save($newsEntry);

            return $this->redirectToRoute('ddr_symfony_angular_rest_example_web_index');
        }

        return $this->render(
            '@DdrSymfonyAngularRestExampleWeb/NewsEntry/edit.html.twig',
            ['form' => $form->createView(), 'newsEntry' => $newsEntry]
        );
    }

    public function deleteAction($id)
    {
        $newsEntryRepository = $this->getDoctrine()->getRepository(NewsEntry::class);
        $newsEntry = $this->loadNewsEntry($id, $newsEntryRepository);

        if (!$this->isGranted('ROLE_ADMIN') || !$newsEntry->getAuthor()->getId() === $this->getUser()->getId()) {
            throw new AccessDeniedException();
        }

        $newsEntryRepository->remove($newsEntry);

        return $this->redirectToRoute('ddr_symfony_angular_rest_example_web_index');
    }

    public function deleteCommentAction($id)
    {
        $commentRepository = $this->getDoctrine()->getRepository(Comment::class);
        $comment = $commentRepository->findOneBy(['id' => $id]);
        if (null == $comment) {
            throw new NotFoundHttpException();
        }

        if (!$this->isGranted('ROLE_ADMIN') || !$comment->getAuthor()->getId() === $this->getUser()->getId()) {
            throw new AccessDeniedException();
        }

        $commentRepository->remove($comment);

        return $this->redirectToRoute(
            'ddr_symfony_angular_rest_example_web_newsentry_detail',
            ['id' => $comment->getNewsEntry()->getId()]
        );
    }

    /**
     * @param int                 $id
     * @param NewsEntryRepository $newsEntryRepository
     *
     * @return NewsEntry
     */
    public function loadNewsEntry($id, $newsEntryRepository = null)
    {
        if (null == $newsEntryRepository) {
            $newsEntryRepository = $this->getDoctrine()->getRepository(NewsEntry::class);
        }

        /** @var NewsEntry|null $newsEntry */
        $newsEntry = $newsEntryRepository->findOneBy(['id' => $id]);
        if (null == $newsEntry) {
            throw new NotFoundHttpException();
        }

        return $newsEntry;
    }
}

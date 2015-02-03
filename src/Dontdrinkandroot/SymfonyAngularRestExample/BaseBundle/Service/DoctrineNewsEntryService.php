<?php


namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Exception\EntityNotFoundException;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository\CommentRepository;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository\NewsEntryRepository;

class DoctrineNewsEntryService implements NewsEntryService
{

    /**
     * @var NewsEntryRepository
     */
    protected $newsEntryRepository;

    /**
     * @var CommentRepository
     */
    protected $commentRepository;

    public function __construct(NewsEntryRepository $newsEntryRepository, CommentRepository $commentRepository)
    {
        $this->newsEntryRepository = $newsEntryRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @return NewsEntry[]
     */
    public function listNewsEntries()
    {
        $newsEntries = $this->newsEntryRepository->findBy([], ['date' => 'DESC']);

        return $newsEntries;
    }

    /**
     * @param int $id
     *
     * @return NewsEntry
     *
     * @throws EntityNotFoundException
     */
    public function getNewsEntry($id)
    {
        $newsEntry = $this->newsEntryRepository->find($id);
        if (null === $newsEntry) {
            throw new EntityNotFoundException();
        }

        return $newsEntry;
    }

    /**
     * @param NewsEntry $newsEntry
     */
    public function deleteNewsEntry(NewsEntry $newsEntry)
    {
        $this->newsEntryRepository->remove($newsEntry);
    }

    /**
     * @param NewsEntry $newsEntry
     *
     * @return NewsEntry
     */
    public function saveNewsEntry($newsEntry)
    {
        return $this->newsEntryRepository->save($newsEntry);
    }

    /**
     * @param int $id
     *
     * @return Comment[]
     */
    public function findComments($id)
    {
        $comments = $this->commentRepository->findBy(['newsEntry' => $id], ['date' => 'DESC']);

        return $comments;
    }

    /**
     * @param int $commentId
     *
     * @return Comment
     *
     * @throws EntityNotFoundException
     */
    public function getComment($commentId)
    {
        $comment = $this->commentRepository->find($commentId);
        if (null === $comment) {
            throw new EntityNotFoundException();
        }

        return $comment;
    }

    /**
     * @param Comment $comment
     */
    public function deleteComment(Comment $comment)
    {
        $this->commentRepository->remove($comment);
    }

    /**
     * @param Comment $comment
     *
     * @return Comment
     */
    public function saveComment($comment)
    {
        return $this->commentRepository->save($comment);
    }
}
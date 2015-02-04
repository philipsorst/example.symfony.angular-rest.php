<?php


namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;

interface NewsEntryService
{

    /**
     * @return NewsEntry[]
     */
    public function listNewsEntries();

    /**
     * @param int $id
     *
     * @return NewsEntry
     */
    public function getNewsEntry($id);

    /**
     * @param NewsEntry $newsEntry
     */
    public function deleteNewsEntry(NewsEntry $newsEntry);

    /**
     * @param NewsEntry $newsEntry
     *
     * @return NewsEntry
     */
    public function saveNewsEntry($newsEntry);

    /**
     * @param int $id
     *
     * @return Comment[]
     */
    public function findComments($id);

    /**
     * @param $commentId
     *
     * @return Comment
     */
    public function getComment($commentId);

    /**
     * @param Comment $comment
     */
    public function deleteComment(Comment $comment);

    /**
     * @param Comment $comment
     *
     * @return Comment
     */
    public function saveComment($comment);
}

<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;

interface NewsEntryService
{

    /**
     * @return NewsEntry[]
     */
    public function listNewsEntries();

    /**
     * @param integer $id
     *
     * @return NewsEntry
     */
    public function getNewsEntry($id);

    /**
     * @param NewsEntry $newsEntry
     */
    public function deleteNewsEntry($newsEntry);
}
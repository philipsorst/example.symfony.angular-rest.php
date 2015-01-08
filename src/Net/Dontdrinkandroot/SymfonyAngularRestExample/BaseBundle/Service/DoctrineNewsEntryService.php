<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository\NewsEntryRepository;

class DoctrineNewsEntryService implements NewsEntryService
{

    /**
     * @var NewsEntryRepository
     */
    protected $newsEntryRepository;

    public function __construct(NewsEntryRepository $newsEntryRepository)
    {
        $this->newsEntryRepository = $newsEntryRepository;
    }

    /**
     * @return NewsEntry[]
     */
    public function listNewsEntries()
    {
        // TODO: Implement listNewsEntries() method.
    }

    /**
     * @param integer $id
     *
     * @return NewsEntry
     */
    public function getNewsEntry($id)
    {
        // TODO: Implement getNewsEntry() method.
    }
}
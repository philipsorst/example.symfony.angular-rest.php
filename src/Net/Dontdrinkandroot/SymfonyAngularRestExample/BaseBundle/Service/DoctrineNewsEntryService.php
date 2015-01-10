<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Service;

use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Exception\ResourceNotFoundException;
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
        $newsEntries = $this->newsEntryRepository->findBy([], ['date' => 'DESC']);

        return $newsEntries;
    }

    /**
     * @param integer $id
     *
     * @return NewsEntry
     *
     * @throws ResourceNotFoundException
     */
    public function getNewsEntry($id)
    {
        $newsEntry = $this->newsEntryRepository->find($id);
        if (null === $newsEntry) {
            throw new ResourceNotFoundException();
        }

        return $newsEntry;
    }

    /**
     * @param NewsEntry $newsEntry
     */
    public function deleteNewsEntry($newsEntry)
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
}
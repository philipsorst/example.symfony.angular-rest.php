<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Entity;

class DoctrineOrmRepository extends EntityRepository
{

    /**
     * Persists or updates the given entity.
     *
     * @param Entity $entity The entity to save.
     *
     * @return Entity The saved entity.
     */
    public function save(Entity $entity)
    {
        if (null === $entity->getId()) {
            $this->_em->persist($entity);
        } else {
            $this->_em->merge($entity);
        }
        $this->_em->flush();

        return $entity;
    }

    /**
     * Finds a single entity by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return Entity|null The object found or null if none was found.
     *
     * @throws \Exception Thrown if too many results were found.
     */
    public function findSingleBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $results = $this->findBy($criteria, $orderBy, $limit, $offset);
        if (count($results) > 1) {
            throw new \Exception('Too many results');
        }

        if (count($results) == 0) {
            return null;
        }

        return $results[0];
    }

    /**
     * @param Entity $entity
     */
    public function remove(Entity $entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }

    public function beginTransation()
    {
        $this->getEntityManager()->beginTransaction();
    }

    public function commitTransaction()
    {
        $this->getEntityManager()->commit();
    }

    public function rollbackTransaction()
    {
        $this->getEntityManager()->rollback();
    }
}
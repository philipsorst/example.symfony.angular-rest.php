<?php

namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Entity;

class DoctrineOrmRepository extends EntityRepository
{

    /**
     * @param Entity $entity
     *
     * @return Entity
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

    public function findSingleBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $results = $this->findBy($criteria, $offset, $limit, $offset);
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
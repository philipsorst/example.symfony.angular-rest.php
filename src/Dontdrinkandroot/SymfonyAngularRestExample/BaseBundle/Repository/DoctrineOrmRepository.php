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

<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Repository;

use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\BlogPost;

/**
 * CommentRepository
 */
class CommentRepository extends DoctrineOrmRepository
{
    public function findCountByBlogPost(BlogPost $blogPost)
    {
        $builder = $this->getEntityManager()->createQueryBuilder();
        $builder
            ->select($builder->expr()->count('comment'))
            ->from($this->_entityName, 'comment')
            ->where('comment.blogPost = :blogPost');
        $builder->setParameter('blogPost', $blogPost);

        return $builder->getQuery()->getSingleScalarResult();
    }
}

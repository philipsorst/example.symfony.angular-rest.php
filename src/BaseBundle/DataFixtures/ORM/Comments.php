<?php


namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;

class Comments extends AbstractOrderedFixture
{

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $blogPost1 = $this->getBlogPostReference(BlogPosts::BLOG_POST_1);
        $blogPost2 = $this->getBlogPostReference(BlogPosts::BLOG_POST_2);

        $admin = $this->getUserReference('admin');
        $user = $this->getUserReference('user');
        $dummy = $this->getUserReference('dummy');

        $blogPost1comment1 = new Comment();
        $blogPost1comment1->setBlogPost($blogPost1);
        $blogPost1comment1->setAuthor($dummy);
        $blogPost1comment1->setDate(new \DateTime());
        $blogPost1comment1->setContent('Blog Post 1 Comment 1');

        $manager->persist($blogPost1comment1);
        $manager->flush();

        $blogPost1comment2 = new Comment();
        $blogPost1comment2->setBlogPost($blogPost1);
        $blogPost1comment2->setAuthor($user);
        $blogPost1comment2->setDate(new \DateTime());
        $blogPost1comment2->setContent('Blog Post 1 Comment 2');

        $manager->persist($blogPost1comment2);
        $manager->flush();

        $blogPost1->setNumComments(2);
        $manager->persist($blogPost1);
        $manager->flush();

        $blogPost2comment1 = new Comment();
        $blogPost2comment1->setBlogPost($blogPost2);
        $blogPost2comment1->setAuthor($user);
        $blogPost2comment1->setDate(new \DateTime());
        $blogPost2comment1->setContent('Blog Post 2 Comment 1');

        $manager->persist($blogPost2comment1);
        $manager->flush();

        $blogPost2->setNumComments(1);
        $manager->persist($blogPost2);
        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 4;
    }
}

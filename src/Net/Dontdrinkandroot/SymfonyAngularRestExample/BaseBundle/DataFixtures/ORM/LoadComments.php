<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\Comment;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\User;

class LoadComments extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        /** @var NewsEntry $newsEntry1 */
        $newsEntry1 = $this->getReference('news-entry-1');

        /** @var NewsEntry $newsEntry2 */
        $newsEntry2 = $this->getReference('news-entry-2');

        /** @var User $admin */
        $admin = $this->getReference('admin');

        /** @var User $user */
        $user = $this->getReference('user');

        /** @var User $dummy */
        $dummy = $this->getReference('dummy');

        $newsEntry1comment1 = new Comment();
        $newsEntry1comment1->setNewsEntry($newsEntry1);
        $newsEntry1comment1->setAuthor($dummy);
        $newsEntry1comment1->setDate(new \DateTime());
        $newsEntry1comment1->setContent('News Entry 1 Comment 1');

        $manager->persist($newsEntry1comment1);
        $manager->flush();

        $newsEntry1comment2 = new Comment();
        $newsEntry1comment2->setNewsEntry($newsEntry1);
        $newsEntry1comment2->setAuthor($user);
        $newsEntry1comment2->setDate(new \DateTime());
        $newsEntry1comment2->setContent('News Entry 1 Comment 2');

        $manager->persist($newsEntry1comment2);
        $manager->flush();

        $newsEntry1->setNumComments(2);
        $manager->persist($newsEntry1);
        $manager->flush();

        $newsEntry2comment1 = new Comment();
        $newsEntry2comment1->setNewsEntry($newsEntry2);
        $newsEntry2comment1->setAuthor($user);
        $newsEntry2comment1->setDate(new \DateTime());
        $newsEntry2comment1->setContent('News Entry 2 Comment 1');

        $manager->persist($newsEntry2comment1);
        $manager->flush();

        $newsEntry2->setNumComments(1);
        $manager->persist($newsEntry2);
        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return integer
     */
    function getOrder()
    {
        return 3;
    }
}
<?php
namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;

class LoadNewsEntries extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $newsEntry1 = new NewsEntry();
        $newsEntry1->setTitle('News Entry 1');
        $newsEntry1->setContent('News Entry 1 Content');
        $newsEntry1->setAuthor($this->getReference('user'));
        $newsEntry1->setDate(new \DateTime());
        $manager->persist($newsEntry1);
        $manager->flush();

        $this->setReference('news-entry-1', $newsEntry1);

        $newsEntry2 = new NewsEntry();
        $newsEntry2->setTitle('News Entry 2');
        $newsEntry2->setContent('News Entry 2 Content');
        $newsEntry2->setAuthor($this->getReference('admin'));
        $newsEntry2->setDate(new \DateTime());
        $manager->persist($newsEntry2);
        $manager->flush();

        $this->setReference('news-entry-2', $newsEntry2);
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    function getOrder()
    {
        return 2;
    }
}
<?php
namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\NewsEntry;

class NewsEntries extends AbstractOrderedFixture
{

    const NEWS_ENTRY_1 = 'news-entry-1';
    const NEWS_ENTRY_2 = 'news-entry-2';

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $newsEntry1 = new NewsEntry();
        $newsEntry1->setTitle('News Entry 1');
        $newsEntry1->setContent('News Entry 1 Content');
        $newsEntry1->setAuthor($this->getUserReference('user'));
        $newsEntry1->setDate(new \DateTime());
        $manager->persist($newsEntry1);
        $manager->flush();

        $this->setReference(self::NEWS_ENTRY_1, $newsEntry1);

        $newsEntry2 = new NewsEntry();
        $newsEntry2->setTitle('News Entry 2');
        $newsEntry2->setContent('News Entry 2 Content');
        $newsEntry2->setAuthor($this->getUserReference('admin'));
        $newsEntry2->setDate(new \DateTime());
        $manager->persist($newsEntry2);
        $manager->flush();

        $this->setReference(self::NEWS_ENTRY_2, $newsEntry2);
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}

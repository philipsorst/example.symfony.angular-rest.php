<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\ApiKey;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApiKeys extends AbstractOrderedFixture implements ContainerAwareInterface
{

    const ADMIN_API_KEY = 'admin-api-key';
    const USER_API_KEY = 'user-api-key';
    const DUMMY_API_KEY = 'dummy-api-key';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $admin = $this->getUserReference('admin');

        $apiKey = new ApiKey($admin, 'admin_token');

        $manager->persist($apiKey);
        $manager->flush();

        $this->addReference(self::ADMIN_API_KEY, $apiKey);

        $user = $this->getUserReference('user');

        $apiKey = new ApiKey($user, 'user_token');

        $manager->persist($apiKey);
        $manager->flush();

        $this->addReference(self::USER_API_KEY, $apiKey);

        $dummy = $this->getUserReference('dummy');

        $apiKey = new ApiKey($dummy, 'dummy_token');

        $manager->persist($apiKey);
        $manager->flush();

        $this->addReference(self::DUMMY_API_KEY, $apiKey);
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}

<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\Entity\ApiKey;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApiKeys extends AbstractFixture implements ContainerAwareInterface, DependentFixtureInterface
{
    const ADMIN_API_KEY = 'admin-api-key';
    const USER_API_KEY = 'user-api-key';
    const DUMMY_API_KEY = 'dummy-api-key';

    /**
     * @var ContainerInterface
     */
    protected $container;

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

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getDependencies()
    {
        return [Users::class];
    }
}

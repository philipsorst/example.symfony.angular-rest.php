<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Users extends AbstractOrderedFixture implements ContainerAwareInterface
{

    const ADMIN = 'admin';
    const USER = 'user';
    const DUMMY = 'dummy';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        /** @var UserManagerInterface $userManager */
        $userManager = $this->container->get('fos_user.user_manager');

        $admin = $userManager->createUser();
        $admin->setUsername('admin');
        $admin->setEmail('admin@example.com');
        $admin->setPlainPassword('admin');
        $admin->setEnabled(true);
        $admin->addRole('ROLE_ADMIN');

        $userManager->updateUser($admin, true);

        $this->addReference(self::ADMIN, $admin);
        $this->addReference('user-1', $admin);

        $user = $userManager->createUser();
        $user->setUsername('user');
        $user->setEmail('user@example.com');
        $user->setPlainPassword('user');
        $user->setEnabled(true);

        $userManager->updateUser($user, true);

        $this->addReference(self::USER, $user);
        $this->addReference('user-2', $user);

        $dummy = $userManager->createUser();
        $dummy->setUsername('dummy');
        $dummy->setEmail('dummy@example.com');
        $dummy->setPlainPassword('dummy');
        $dummy->setEnabled(true);

        $userManager->updateUser($dummy, true);

        $this->addReference(self::DUMMY, $dummy);
        $this->addReference('user-3', $dummy);
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    function getOrder()
    {
        return 1;
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
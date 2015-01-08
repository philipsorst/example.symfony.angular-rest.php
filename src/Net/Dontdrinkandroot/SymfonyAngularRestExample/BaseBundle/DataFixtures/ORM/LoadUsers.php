<?php

namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

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

        $this->addReference('admin', $admin);

        $user = $userManager->createUser();
        $user->setUsername('user');
        $user->setEmail('user@example.com');
        $user->setPlainPassword('user');
        $user->setEnabled(true);

        $userManager->updateUser($user, true);

        $this->addReference('user', $user);
    }

    /**
     * Get the order of this fixture.
     *
     * @return integer
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
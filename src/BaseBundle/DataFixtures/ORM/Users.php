<?php

namespace Dontdrinkandroot\SymfonyAngularRestExample\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Users extends AbstractFixture implements ContainerAwareInterface
{
    const ADMIN = 'admin';
    const USER = 'user';
    const DUMMY = 'dummy';

    const USER_PASSWORD = 'user';

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function load(ObjectManager $manager)
    {
        /** @var UserManagerInterface $userManager */
        $userManager = $this->container->get('fos_user.user_manager');

        $admin = $userManager->createUser();
        $admin->setUsername('admin');
        $admin->setEmail('admin@example.com');
        $admin->setPlainPassword('admin');
        $admin->setEnabled(true);
        $admin->addRole('ROLE_ADMIN');

        $userManager->updateUser($admin);

        $this->addReference(self::ADMIN, $admin);
        $this->addReference('user-1', $admin);

        $user = $userManager->createUser();
        $user->setUsername(self::USER);
        $user->setEmail('user@example.com');
        $user->setPlainPassword(self::USER_PASSWORD);
        $user->setEnabled(true);

        $userManager->updateUser($user);

        $this->addReference(self::USER, $user);
        $this->addReference('user-2', $user);

        $dummy = $userManager->createUser();
        $dummy->setUsername('dummy');
        $dummy->setEmail('dummy@example.com');
        $dummy->setPlainPassword('dummy');
        $dummy->setEnabled(true);

        $userManager->updateUser($dummy);

        $this->addReference(self::DUMMY, $dummy);
        $this->addReference('user-3', $dummy);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}

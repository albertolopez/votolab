<?php

namespace Votolab\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setUsername('admin');
        $user->setEmail('admin@admin.com');
        $user->setPlainPassword('12345');
        $user->addRole('ROLE_SUPER_ADMIN');
        $user->setEnabled(true);
        $userManager->updateUser($user);
        $this->addReference('admin', $user);

        $faker = \Faker\Factory::create();
        for($i=0; $i<30; $i++)
        {
            $user = $userManager->createUser();
            $user->setUsername($faker->username);
            $user->setEmail($faker->email);
            $user->setPlainPassword('password');
            $user->addRole('ROLE_USER');
            $user->setEnabled(true);
            $userManager->updateUser($user);
            $this->addReference('user-'.$i, $user);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}
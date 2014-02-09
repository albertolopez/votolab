<?php

namespace Votolab\VotolabBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadElectionData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
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
        /*
        $electionManager = $this->container->get('election_manager');

        $faker = \Faker\Factory::create();
        for($i=0; $i<30; $i++)
        {
            $election = $electionManager->createElection();
            $election->setTitle($faker->sentence());
            $electionManager->persist($election);
            $this->addReference('election-'.$i, $election);
        }
        */
    }

    public function getOrder()
    {
        return 2;
    }
}
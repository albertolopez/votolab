<?php

namespace Votolab\VotolabBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadElectionCriteriaData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
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
        $criteriaManager = $this->container->get('criteria_manager');

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 90; $i++) {
            $criteria = $criteriaManager->createElectionCriteria();

            $criteria->setElection($this->getReference('election-' . rand(0, 29)));
            $criteria->setCriterion($faker->sentence());
            $criteria->setMin($faker->randomNumber());
            $criteria->setMax($faker->randomNumber());
            $criteriaManager->persist($criteria);
            $this->addReference('criteria-' . $i, $criteria);
        }
    }

    public function getOrder()
    {
        return 4;
    }
}
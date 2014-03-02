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
        for ($i = 0; $i < 40; $i++) {
            $criteria = $criteriaManager->createElectionCriteria();

            $criteria->setElection($this->getReference('election-' . rand(0, 9)));
            $criteria->setCriterion($faker->sentence());
            $criteria->setMin(1);
            $criteria->setMax(5);
            $criteriaManager->persist($criteria);
            $this->addReference('criteria-' . $i, $criteria);
        }
    }

    public function getOrder()
    {
        return 4;
    }
}
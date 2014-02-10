<?php

namespace Votolab\VotolabBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadCandidateData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
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
        $candidateManager = $this->container->get('candidate_manager');

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 150; $i++) {
            $candidate = $candidateManager->createCandidate();
            $candidate->setName($faker->name);
            $candidate->setBiography($faker->paragraph());
            $candidate->setVideo($faker->url);
            $candidate->setGender($faker->boolean());
            $candidate->setElection($this->getReference('election-' . rand(0, 29)));
            $candidateManager->persist($candidate);
            $this->addReference('candidate-' . $i, $candidate);
        }
    }

    public function getOrder()
    {
        return 3;
    }
}
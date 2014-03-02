<?php

namespace Votolab\VotolabBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadVoteData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
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
        $voteManager = $this->container->get('vote_manager');

        for ($i = 0; $i < 300; $i++) {
            $vote = $voteManager->createVote();
            $election = $this->getReference('election-' . rand(0, 9));
            $user = $this->getReference('user-' . rand(0, 9));
            $candidate = $this->getReference('candidate-' . rand(0, 9));
            $vote->setElection($election);
            $vote->setUser($user);
            $vote->setCandidate($candidate);
            $vote->setCriterion($this->getReference('criteria-' . rand(0, 9)));
            $vote->setVote(rand(1, 5));
            $voteManager->persist($vote);
            $this->addReference('vote-' . $i, $vote);
        }
    }

    public function getOrder()
    {
        return 5;
    }
}
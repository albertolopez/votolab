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

        $electionManager = $this->container->get('election_manager');
        $em = $this->container->get('doctrine')->getEntityManager();

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 30; $i++) {
            $startDate = $faker->dateTimeThisMonth;
            $election = $electionManager->createElection();
            $election->setTitle($faker->sentence());
            $election->setSlug($faker->word);
            $election->setDescription($faker->text(500));
            $election->setDateStart($faker->dateTimeBetween('-30 days', '-10 days'));
            $election->setDateEnd($faker->dateTimeBetween('-10 days', '+10 days'));
            $election->setMinCandidates($faker->randomNumber());
            $election->setMaxCandidates($faker->randomNumber());
            $election->setPublishResults($faker->boolean());
            $election->setDatePublished($startDate);
            $electionManager->persist($election);

            $user = $this->getReference('user-' . rand(1, 29));
            $user->addElection($election);
            $user = $this->getReference('user-0');
            $user->addElection($election);
            $em->persist($user);
            $em->flush();

            $this->addReference('election-' . $i, $election);
        }
    }

    public function getOrder()
    {
        return 2;
    }
}
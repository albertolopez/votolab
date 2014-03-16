<?php

namespace Votolab\VotolabBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Votolab\VotolabBundle\Entity\Image;

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
        $faker->addProvider(new \Faker\Provider\Image($faker));
        $xml = simplexml_load_file('http://gdata.youtube.com/feeds/base/standardfeeds/most_popular');
        for ($i = 0; $i < 150; $i++) {
            $image = new Image();
            $imagePath = $faker->image('web/files/images', 227, 200, 'people');
            $image->setName(str_replace('web/files/images/','',$imagePath));
            $image->setPath(str_replace('web/','',$imagePath));
            $image->setContentType('image/jpeg');
            $image->setSize(filesize($imagePath));
            $candidate = $candidateManager->createCandidate();
            $candidate->setName($faker->name);
            $candidate->setBiography($faker->text(1000));
            $candidate->setVideo(str_replace('&feature=youtube_gdata', '', $xml->entry[($i % 10)]->link[0]['href']));
            $candidate->setGender($faker->boolean());
            $candidate->setImage($image);
            $candidate->setCompetence($faker->text());
            $candidate->setElection($this->getReference('election-' . rand(0, 9)));
            $candidateManager->persist($candidate);
            $this->addReference('candidate-' . $i, $candidate);
        }
    }

    public function getOrder()
    {
        return 3;
    }
}
<?php

namespace Votolab\VotolabBundle\Model;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Votolab\VotolabBundle\Entity\Election;

/**
 * election_manager
 */
class ElectionManager
{
    protected $em;
    protected $dispatcher;

    public function __construct(
        EntityManager $em,
        EventDispatcherInterface $dispatcher
    ) {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
    }

    public function findForUser($user)
    {
        $query = $this->em->getRepository('VotolabBundle:Election')->findForUser($user);
        return $query->getResult();
    }

    public function isVoterForElection($user, $election)
    {
        $query = $this->em->getRepository('VotolabBundle:Election')->isVoterForElection($user, $election);
        return $query->getResult();
    }

    public function createElection()
    {
        return new Election();
    }
}
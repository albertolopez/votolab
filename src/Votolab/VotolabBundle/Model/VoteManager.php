<?php

namespace Votolab\VotolabBundle\Model;

use Votolab\VotolabBundle\Entity\Vote;
use Votolab\VotolabBundle\Entity\Election;

/**
 * vote_manager
 */
class VoteManager extends ManagerAbstract
{
    public function createVote()
    {
        return new Vote();
    }

    public function persist(Vote $candidate)
    {
        $this->em->persist($candidate);
        $this->em->flush();
    }

    public function findByElection(Election $election)
    {
        //$votes = $this->em->getRepository('VotolabBundle:Vote')->findByElection($election, array('candidate' => 'ASC'));
        //return $votes;
        $q = $this->em->createQuery('select v from Votolab\VotolabBundle\Entity\Vote v
            left join v.candidate c
            where v.election = :election order by c.name asc');
        $q->setParameter('election' , $election);

        return $q->getResult();

    }

}
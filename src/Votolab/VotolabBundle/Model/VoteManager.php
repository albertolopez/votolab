<?php

namespace Votolab\VotolabBundle\Model;

use Votolab\VotolabBundle\Entity\Vote;

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
}
<?php

namespace Votolab\VotolabBundle\Model;

use Votolab\VotolabBundle\Entity\Candidate;

/**
 * candidate_manager
 */
class CandidateManager extends ManagerAbstract
{
    public function createCandidate()
    {
        return new Candidate();
    }

    public function persist(Candidate $candidate)
    {
        $this->em->persist($candidate);
        $this->em->flush();
    }
}
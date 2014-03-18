<?php

namespace Votolab\VotolabBundle\Model;

use Votolab\VotolabBundle\Entity\Candidate;
use Votolab\VotolabBundle\Entity\Election;
use Votolab\VotolabBundle\Form\Model\CandidateFormClass;

/**
 * candidate_manager
 */
class CandidateManager extends ManagerAbstract
{
    public function createCandidate()
    {
        return new Candidate();
    }

    public function create(CandidateFormClass $electionFormClass)
    {
        if (is_numeric($electionFormClass->id)) {
            $candidate = $this->em->getRepository('VotolabBundle:Candidate')->find($electionFormClass->id);
        } else {
            $candidate = new Candidate();
        }
        $candidate->setBiography($electionFormClass->biography);
        $candidate->setGender($electionFormClass->gender);
        $candidate->setName($electionFormClass->name);
        $candidate->setCompetence($electionFormClass->competence);
        $candidate->setVideo($electionFormClass->video);
        $candidate->setImage($electionFormClass->image);
        $candidate->setElection($electionFormClass->election);
        $this->em->persist($candidate);
        $this->em->flush();
        return true;
    }

    public function persist(Candidate $candidate)
    {
        $this->em->persist($candidate);
        $this->em->flush();
    }

    public function remove(Candidate $election)
    {
        $this->em->remove($election);
        $this->em->flush();
    }

    public function findByElectionOrderRandom(Election $election)
    {
        $candidates = $this->em->getRepository('VotolabBundle:Candidate')->findByElection($election);
        shuffle($candidates);
        return $candidates;
    }
}
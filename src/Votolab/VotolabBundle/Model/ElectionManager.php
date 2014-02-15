<?php

namespace Votolab\VotolabBundle\Model;

use Votolab\VotolabBundle\Entity\Election;
use Votolab\VotolabBundle\Entity\ElectionCriteria;
use Votolab\VotolabBundle\Form\Model\ElectionFormClass;

/**
 * election_manager
 */
class ElectionManager extends ManagerAbstract
{
    public function findForUser($user)
    {
        $query = $this->em->getRepository('VotolabBundle:Election')->findForUser($user);
        return $query->getResult();
    }

    public function findForUserPast($user)
    {
        $query = $this->em->getRepository('VotolabBundle:Election')->findForUserPast($user);
        return $query->getResult();
    }

    public function findAllElections()
    {
        return $this->em->getRepository('VotolabBundle:Election')->findAll();
    }

    public function isVoterForElection($user, $election)
    {
        $query = $this->em->getRepository('VotolabBundle:Election')->isVoterForElection($user, $election);
        return $query->getResult();
    }

    public function getElectionTally($election)
    {
        $query = $this->em->getRepository('VotolabBundle:Election')->getElectionTally($election);
        $query->execute();
        return $query->fetchAll();

    }

    public function createElection()
    {
        return new Election();
    }

    public function create(ElectionFormClass $electionFormClass)
    {
        if (is_numeric($electionFormClass->id)) {
            $election = $this->em->getRepository('VotolabBundle:Election')->find($electionFormClass->id);
        } else {
            $election = new Election();
        }
        $election->setTitle($electionFormClass->title);
        $election->setDescription($electionFormClass->description);
        $election->setSlug($electionFormClass->slug);
        $election->setDateEnd($electionFormClass->dateEnd);
        $election->setDateStart($electionFormClass->dateStart);
        $election->setDatePublished($electionFormClass->datePublished);
        $election->setMaxCandidates($electionFormClass->maxCandidates);
        $election->setMinCandidates($electionFormClass->minCandidates);
        $election->setPublishResults($electionFormClass->publishResults);
        $this->em->persist($election);
        $this->em->flush();
        return true;
    }

    public function persist(Election $election)
    {
        $this->em->persist($election);
        $this->em->flush();
    }

    public function createElectionCriteria()
    {
        return new ElectionCriteria();
    }

    public function persistCriteria(ElectionCriteria $criteria)
    {
        $this->em->persist($criteria);
        $this->em->flush();
    }
}
<?php

namespace Votolab\VotolabBundle\Model;

use Votolab\VotolabBundle\Entity\ElectionCriteria;
use Votolab\VotolabBundle\Form\Model\CriteriaFormClass;

/**
 * criteria_manager
 */
class CriteriaManager extends ManagerAbstract
{


    public function create(CriteriaFormClass $criteriaFormClass)
    {
        if (is_numeric($criteriaFormClass->id)) {
            $criteria = $this->em->getRepository('VotolabBundle:ElectionCriteria')->find($criteriaFormClass->id);
        } else {
            $criteria = new ElectionCriteria();
        }
        $criteria->setCriterion($criteriaFormClass->criterion);
        $criteria->setElection($criteriaFormClass->election);
        $criteria->setMax($criteriaFormClass->max);
        $criteria->setMin($criteriaFormClass->min);
        $this->em->persist($criteria);
        $this->em->flush();
        return true;
    }

    public function persist(ElectionCriteria $election)
    {
        $this->em->persist($election);
        $this->em->flush();
    }

    public function createElectionCriteria()
    {
        return new ElectionCriteria();
    }

    public function remove(ElectionCriteria $criteria)
    {
        $this->em->remove($criteria);
        $this->em->flush();
    }
}
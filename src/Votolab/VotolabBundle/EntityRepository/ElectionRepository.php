<?php

namespace Votolab\VotolabBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

/**
 * ElectionRepository
 *
 */
class ElectionRepository extends EntityRepository
{
    public function findForUser($user)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e FROM Votolab\VotolabBundle\Entity\Election e
                                LEFT JOIN e.voters v
                                WHERE e.dateStart < CURRENT_TIMESTAMP() AND e.dateEnd > CURRENT_TIMESTAMP()
                                AND v.id = :user'
            )->setParameter('user', $user->getId());
    }

    public function isVoterForElection($user, $election)
    {
        return $this->getEntityManager()
            ->createQuery(
                '
                SELECT e FROM Votolab\VotolabBundle\Entity\Election e
                LEFT JOIN e.voters v
                WHERE e.dateStart < CURRENT_TIMESTAMP() AND e.dateEnd > CURRENT_TIMESTAMP()
                AND v.id = :user AND e.id = :electionId'
            )->setParameter('user', $user->getId())
            ->setParameter('electionId', $election->getId());
    }

}
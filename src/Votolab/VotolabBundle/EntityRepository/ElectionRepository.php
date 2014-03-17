<?php

namespace Votolab\VotolabBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

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
                                AND v = :user'
            )->setParameter('user', $user);
    }

    public function findForUserPublished($user)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e FROM Votolab\VotolabBundle\Entity\Election e
                                LEFT JOIN e.voters v
                                WHERE e.dateEnd < CURRENT_TIMESTAMP()
                                AND v = :user AND e.publishResults = true'
            )->setParameter('user', $user);
    }

    public function findForUserUpcoming($user)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e FROM Votolab\VotolabBundle\Entity\Election e
                                LEFT JOIN e.voters v
                                WHERE e.dateStart > CURRENT_TIMESTAMP()
                                AND v = :user'
            )->setParameter('user', $user);
    }

    public function isVoterForElection($user, $election)
    {
        return $this->getEntityManager()
            ->createQuery(
                '
                SELECT e FROM Votolab\VotolabBundle\Entity\Election e
                LEFT JOIN e.voters v
                WHERE v = :user AND e = :election'
            )->setParameter('user', $user)
            ->setParameter('election', $election);
    }

    public function getElectionTally($election)
    {
        $rsm = new ResultSetMapping();
        $query =$this->getEntityManager()
            ->getConnection()
            ->prepare(
                '
                SELECT c.*, SUM(v.vote) as candidate_votes, (100 * SUM(v.vote)) / max_votes as percentage FROM Candidate c
                LEFT JOIN Vote v On c.id = v.candidate_id
                LEFT JOIN (
                    SELECT MAX(candidate_votes) max_votes FROM (
                        SELECT SUM(v.vote) as candidate_votes FROM Vote v
                        WHERE v.election_id = :election
                        GROUP BY v.candidate_id
                    ) s
                ) m ON true = true
                WHERE v.election_id = :election
                GROUP BY c.id
                ORDER BY percentage DESC
                ', $rsm
            );

        $query->bindValue('election', $election->getId());
        return $query;
    }
}
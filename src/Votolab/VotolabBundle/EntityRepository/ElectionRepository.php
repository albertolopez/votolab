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

    public function findForUserPast($user)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e FROM Votolab\VotolabBundle\Entity\Election e
                                LEFT JOIN e.voters v
                                WHERE e.dateEnd < CURRENT_TIMESTAMP()
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
                SELECT *, 1 + 4*((x + z*z/(2*n) - z*sqrt(x*(1-x)/n + z*z/(4*n*n)))/(1 + z*z/n)) as wilson
                FROM (

                SELECT c.*, COUNT(*) AS n, SUM(voteAvg.vote) AS sumaVotos, 1.96 AS z, (SUM(voteAvg.vote)/COUNT(c.id) - 1)/4 AS x
                FROM Candidate c
                LEFT JOIN
                (SELECT AVG(v.vote) AS vote, election_id, candidate_id, user_id, criterion_id FROM Vote v
                GROUP BY v.election_id, v.candidate_id, v.user_id) voteAvg ON voteAvg.candidate_id = c.id
                WHERE voteAvg.election_id = :election
                GROUP BY c.id

                ) calculation
                 ORDER BY wilson DESC', $rsm
            );
        $query->bindValue('election', $election->getId());
        return $query;
    }

}
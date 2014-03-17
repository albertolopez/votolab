<?php

namespace Votolab\UserBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

/**
 * ElectionRepository
 *
 */
class ElectionRepository extends EntityRepository
{
    public function findNew()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e FROM Votolab\UserBundle\Entity\User u
                 WHERE e.welcome_sent = false'
            );
    }
}
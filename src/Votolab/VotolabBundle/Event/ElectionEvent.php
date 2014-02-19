<?php

namespace Votolab\VotolabBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Votolab\VotolabBundle\Entity\Election;

/**
 * An event that occurs related to a election.
 *
 */
class ElectionEvent extends Event
{
    private $election;

    /**
     * Constructs an event.
     *
     * @param Election $election
     */
    public function __construct(Election $election)
    {
        $this->election = $election;
    }

    /**
     * Returns the election for this event.
     *
     * @return Election
     */
    public function getElection()
    {
        return $this->election;
    }
}
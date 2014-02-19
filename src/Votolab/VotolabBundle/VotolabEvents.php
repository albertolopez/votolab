<?php

namespace Votolab\VotolabBundle;

/**
 * Contains all events thrown in the VotolabBundle
 */
final class VotolabEvents
{
    /**
     * The ELECTION_PUBLISHED event occurs when an election is published.
     *
     * This event allows you to set actions once an election has been published.
     * The event listener method receives a Votolab\VotolabBundle\Event\ElectionEvent instance.
     */
    const ELECTION_PUBLISHED = 'votolab.election.published';
}
<?php

namespace Votolab\VotolabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Votolab\UserBundle\Entity\User;

/**
 * Vote
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Vote
{
    /**
     * @var Election
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Votolab\VotolabBundle\Entity\Election", inversedBy="votes")
     */
    private $election;

    /**
     * @var Candidate
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Votolab\VotolabBundle\Entity\Candidate", inversedBy="votes")
     */
    private $candidate;

    /**
     * @var User
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Votolab\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var ElectionCriteria
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Votolab\VotolabBundle\Entity\ElectionCriteria", inversedBy="votes")
     */
    private $criterion;

    /**
     * @var string
     *
     * @ORM\Column(name="vote", type="string", length=255)
     */
    private $vote;

    /**
     * @ORM\Column(type="datetime")
     */
    private $voted_at;

    /**
     * Set election
     *
     * @param Election $election
     * @return Vote
     */
    public function setElection(Election $election)
    {
        $this->election = $election;

        return $this;
    }

    /**
     * Get election
     *
     * @return Election
     */
    public function getElection()
    {
        return $this->election;
    }

    /**
     * Set candidate
     *
     * @param Candidate $candidate
     * @return Candidate
     */
    public function setCandidate(Candidate $candidate)
    {
        $this->candidate = $candidate;

        return $this;
    }

    /**
     * Get candidate
     *
     * @return Candidate
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * Set User
     *
     * @param User $user
     * @return Vote
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get User
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set criterion
     *
     * @param ElectionCriteria $criterion
     * @return Vote
     */
    public function setCriterion(ElectionCriteria $criterion)
    {
        $this->criterion = $criterion;

        return $this;
    }

    /**
     * Get criterion
     *
     * @return ElectionCriteria
     */
    public function getCriterion()
    {
        return $this->criterion;
    }

    /**
     * Set vote
     *
     * @param string $vote
     * @return Vote
     */
    public function setVote($vote)
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote
     *
     * @return string
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set voted_at
     *
     * @param string $voted_at
     */
    public function setVotedAt($voted_at)
    {
        $this->voted_at = $voted_at;
    }

    /**
     * Get vote
     *
     * @return string
     */
    public function getVotedAt()
    {
        return $this->voted_at;
    }
}

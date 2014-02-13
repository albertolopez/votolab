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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Election
     * @ORM\ManyToOne(targetEntity="Votolab\VotolabBundle\Entity\Election", inversedBy="votes")
     */
    private $election;

    /**
     * @var Candidate
     * @ORM\ManyToOne(targetEntity="Candidate")
     */
    private $candidate;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Votolab\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var ElectionCriteria
     * @ORM\ManyToOne(targetEntity="Votolab\VotolabBundle\Entity\ElectionCriteria")
     */
    private $criterion;

    /**
     * @var string
     *
     * @ORM\Column(name="vote", type="string", length=255)
     */
    private $vote;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

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
}

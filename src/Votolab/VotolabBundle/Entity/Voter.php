<?php

namespace Votolab\VotolabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Voter
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Voter
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
     * @var integer
     *
     * @ORM\Column(name="fos_user_id", type="integer")
     */
    private $fosUserId;

    /**
     * @var integer
     *
     * @ORM\Column(name="election_id", type="integer")
     */
    private $electionId;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255)
     */
    private $alias;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="vote_date", type="datetime")
     */
    private $voteDate;

    /**
     * @var string
     *
     * @ORM\Column(name="vote_tracker", type="string", length=255)
     */
    private $voteTracker;


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
     * Set fosUserId
     *
     * @param integer $fosUserId
     * @return Voter
     */
    public function setFosUserId($fosUserId)
    {
        $this->fosUserId = $fosUserId;

        return $this;
    }

    /**
     * Get fosUserId
     *
     * @return integer 
     */
    public function getFosUserId()
    {
        return $this->fosUserId;
    }

    /**
     * Set electionId
     *
     * @param integer $electionId
     * @return Voter
     */
    public function setElectionId($electionId)
    {
        $this->electionId = $electionId;

        return $this;
    }

    /**
     * Get electionId
     *
     * @return integer 
     */
    public function getElectionId()
    {
        return $this->electionId;
    }

    /**
     * Set alias
     *
     * @param string $alias
     * @return Voter
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set voteDate
     *
     * @param \DateTime $voteDate
     * @return Voter
     */
    public function setVoteDate($voteDate)
    {
        $this->voteDate = $voteDate;

        return $this;
    }

    /**
     * Get voteDate
     *
     * @return \DateTime 
     */
    public function getVoteDate()
    {
        return $this->voteDate;
    }

    /**
     * Set voteTracker
     *
     * @param string $voteTracker
     * @return Voter
     */
    public function setVoteTracker($voteTracker)
    {
        $this->voteTracker = $voteTracker;

        return $this;
    }

    /**
     * Get voteTracker
     *
     * @return string 
     */
    public function getVoteTracker()
    {
        return $this->voteTracker;
    }
}

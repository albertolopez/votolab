<?php

namespace Votolab\VotolabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var integer
     * @ORM\ManyToOne(targetEntity="Election")
     * @ORM\Column(name="election_id", type="integer")
     */
    private $electionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="fos_user_id", type="integer")
     */
    private $fosUserId;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\Column(name="criterion_id", type="integer")
     */
    private $criterionId;

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
     * Set electionId
     *
     * @param integer $electionId
     * @return Vote
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
     * Set fosUserId
     *
     * @param integer $fosUserId
     * @return Vote
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
     * Set criterionId
     *
     * @param integer $criterionId
     * @return Vote
     */
    public function setCriterionId($criterionId)
    {
        $this->criterionId = $criterionId;

        return $this;
    }

    /**
     * Get criterionId
     *
     * @return integer 
     */
    public function getCriterionId()
    {
        return $this->criterionId;
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

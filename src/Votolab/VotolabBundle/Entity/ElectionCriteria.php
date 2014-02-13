<?php

namespace Votolab\VotolabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ElectionCriteria
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ElectionCriteria
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
     * @ORM\ManyToOne(targetEntity="Election")
     */
    private $election;

    /**
     * @var string
     *
     * @ORM\Column(name="criterion", type="text")
     */
    private $criterion;

    /**
     * @var integer
     *
     * @ORM\Column(name="min", type="integer")
     */
    private $min;

    /**
     * @var integer
     *
     * @ORM\Column(name="max", type="integer")
     */
    private $max;

    /**
     * @ORM\OneToMany(targetEntity="Votolab\VotolabBundle\Entity\Vote", mappedBy="criterion", cascade={"remove"})
     */
    private $votes;


    /**
     * @param mixed $votes
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;
    }

    /**
     * @return mixed
     */
    public function getVotes()
    {
        return $this->votes;
    }

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
     * @param Election $election
     * @return ElectionCriteria
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
     * Set criterion
     *
     * @param string $criterion
     * @return ElectionCriteria
     */
    public function setCriterion($criterion)
    {
        $this->criterion = $criterion;

        return $this;
    }

    /**
     * Get criterion
     *
     * @return string 
     */
    public function getCriterion()
    {
        return $this->criterion;
    }

    /**
     * Set min
     *
     * @param integer $min
     * @return ElectionCriteria
     */
    public function setMin($min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Get min
     *
     * @return integer 
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set max
     *
     * @param integer $max
     * @return ElectionCriteria
     */
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Get max
     *
     * @return integer 
     */
    public function getMax()
    {
        return $this->max;
    }
}

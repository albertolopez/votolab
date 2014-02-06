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
     * @var integer
     *
     * @ORM\Column(name="election_id", type="integer")
     */
    private $electionId;

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
     * @return ElectionCriteria
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

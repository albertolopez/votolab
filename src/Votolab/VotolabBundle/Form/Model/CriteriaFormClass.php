<?php
namespace Votolab\VotolabBundle\Form\Model;

use Votolab\VotolabBundle\Entity\Candidate;
use Symfony\Component\Validator\Constraints as Assert;
use Votolab\VotolabBundle\Entity\Election;
use Votolab\VotolabBundle\Entity\ElectionCriteria;

class CriteriaFormClass
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @Assert\NotBlank(message="Introduce un criterio")
     * @var string
     */
    public $criterion;
    /**
     * @var Election
     */
    public $election;
    /**
     * @var integer
     */
    public $min;
    /**
     * @var integer
     */
    public $max;

    public function __construct(ElectionCriteria $criteria)
    {
        $this->id = $criteria->getId();
        $this->criterion = $criteria->getCriterion();
        $this->election = $criteria->getElection();
        $this->min = $criteria->getMin();
        $this->max = $criteria->getMax();
    }
}
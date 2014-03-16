<?php
namespace Votolab\VotolabBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Votolab\VotolabBundle\Entity\Election;

class ImportVotersFormClass
{
    /**
     * @var string
     */
    public $voters;
    /**
     * @var Election
     */
    public $election;

    public function __construct(Election $election)
    {
        $this->election = $election;
    }
}
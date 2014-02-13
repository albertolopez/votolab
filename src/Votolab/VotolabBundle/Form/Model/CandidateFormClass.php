<?php
namespace Votolab\VotolabBundle\Form\Model;

use Votolab\VotolabBundle\Entity\Candidate;
use Symfony\Component\Validator\Constraints as Assert;
use Votolab\VotolabBundle\Entity\Election;

class CandidateFormClass
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @Assert\NotBlank(message="Nombre es obligatorio")
     * @var string
     */
    public $name;
    /**
     * @Assert\NotBlank(message="Introduce una bio")
     * @var string
     */
    public $biography;
    /**
     * @var string
     */
    public $video;
    /**
     * @var integer
     */
    public $gender;
    /**
     * @var Election
     */
    public $election;

    public function __construct(Candidate $candidate)
    {
        $this->id = $candidate->getId();
        $this->name = $candidate->getName();
        $this->biography = $candidate->getBiography();
        $this->video = $candidate->getVideo();
        $this->gender = $candidate->getGender();
        $this->election = $candidate->getElection();
    }
}
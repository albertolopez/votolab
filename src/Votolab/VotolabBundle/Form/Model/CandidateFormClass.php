<?php
namespace Votolab\VotolabBundle\Form\Model;

use Votolab\VotolabBundle\Entity\Candidate;
use Symfony\Component\Validator\Constraints as Assert;
use Votolab\VotolabBundle\Entity\Election;
use Votolab\VotolabBundle\Entity\Image;
use Vlabs\MediaBundle\Annotation\Vlabs;

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
     * @var string
     */
    public $competence;
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
     * @var Image
     *
     * @Vlabs\Media(identifier="image_entity", upload_dir="files/images")
     */
    public $image;
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
        $this->competence = $candidate->getCompetence();
        $this->biography = $candidate->getBiography();
        $this->video = $candidate->getVideo();
        $this->image = $candidate->getImagePath();
        $this->gender = $candidate->getGender();
        $this->election = $candidate->getElection();
    }


    public function getImage()
    {
        return $this->image;
    }
}
<?php
namespace Votolab\VotolabBundle\Form\Model;

use Votolab\VotolabBundle\Entity\Election;
use Symfony\Component\Validator\Constraints as Assert;

class ElectionFormClass
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @Assert\NotBlank(message="Título es obligatorio")
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $description;
    /**
     * @var string
     */
    public $description_tally;
    /**
     * @var string
     * @Assert\NotBlank(message="Introduce una url")
     */
    public $slug;
    /**
     * @var \DateTime
     */
    public $dateStart;

    /**
     * @var \DateTime
     */
    public $dateEnd;

    /**
     * @var \DateTime
     */
    public $datePublished;

    /**
     * @var integer
     */
    public $minCandidates = 1;

    /**
     * @var integer
     */
    public $maxCandidates = 999;

    /**
     * @var boolean
     */
    public $publishResults;


    public function __construct(Election $election)
    {
        $this->id = $election->getId();
        $this->title = $election->getTitle();
        $this->description = $election->getDescription();
        $this->description_tally = $election->getDescriptionTally();
        $this->slug = $election->getSlug();
        $this->dateStart = $election->getDateStart();
        $this->dateEnd = $election->getDateEnd();
        $this->minCandidates = $election->getMinCandidates();
        $this->maxCandidates = $election->getMaxCandidates();
        $this->publishResults = $election->getPublishResults();
        $this->datePublished = $election->getDatePublished();
    }
}
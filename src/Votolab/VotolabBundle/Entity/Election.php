<?php

namespace Votolab\VotolabBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Votolab\UserBundle\Entity\User;

/**
 * Election
 *
 * @ORM\Entity(repositoryClass="Votolab\VotolabBundle\EntityRepository\ElectionRepository")
 */
class Election
{
    const STATUS_DRAFT = 0;
    const STATUS_PREVIEW = 1;
    const STATUS_OPEN = 2;
    const STATUS_CLOSED = 3;
    const STATUS_PUBLISHED = 4;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="description_tally", type="text")
     */
    private $description_tally;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="datetime")
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime")
     */
    private $dateEnd;

    /**
     * @var integer
     *
     * @ORM\Column(name="min_candidates", type="integer")
     */
    private $minCandidates;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_candidates", type="integer")
     */
    private $maxCandidates;

    /**
     * @var boolean
     *
     * @ORM\Column(name="publish_results", type="boolean")
     */
    private $publishResults;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_published", type="datetime")
     */
    private $datePublished;

    /**
     * var User
     * @ORM\ManyToMany(targetEntity="Votolab\UserBundle\Entity\User", mappedBy="elections")
     **/
    private $voters;

    /**
     * var Candidate
     * @ORM\OneToMany(targetEntity="Votolab\VotolabBundle\Entity\Candidate", mappedBy="election", cascade={"remove"})
     */
    private $candidates;

    /**
     * var Vote
     * @ORM\OneToMany(targetEntity="Votolab\VotolabBundle\Entity\Vote", mappedBy="election", cascade={"remove"})
     */
    private $votes;

    /**
     * var ElectionCriteria
     * @ORM\OneToMany(targetEntity="Votolab\VotolabBundle\Entity\ElectionCriteria", mappedBy="election", cascade={"remove"})
     */
    private $electionCriterias;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status = 0;

    public function __construct() {
        $this->voters = new ArrayCollection();
        $this->candidates = new ArrayCollection();
        $this->electionCriterias = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    /**
     * @param mixed $votes
     */
    public function setVotes(array $votes)
    {
        $this->votes = $votes;
    }

    /**
     * @return array
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @param array $criteria
     */
    public function setElectionCriteria(array $criteria)
    {
        $this->electionCriterias = $criteria;
    }

    /**
     * @return array
     */
    public function getElectionCriteria()
    {
        return $this->electionCriterias;
    }

    public function addElectionCriteria(ElectionCriteria $criteria)
    {
        $this->electionCriterias[] = $criteria;
    }


    /**
     * @param array $candidates
     */
    public function setCandidates(array $candidates)
    {
        $this->candidates = $candidates;
    }

    /**
     * @return array
     */
    public function getCandidates()
    {
        return $this->candidates;
    }

    public function addCandidate(Candidate $candidate)
    {
        $this->candidates[] = $candidate;
    }

    /**
     * @param User $user
     */
    public function addVoter(User $user)
    {
        $this->voters[] = $user;
    }

    /**
     * @return ArrayCollection
     */
    public function getVoters()
    {
        return $this->voters;
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
     * Set title
     *
     * @param string $title
     * @return Election
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Election
     */
    public function setSlug($slug)
    {
        $this->slug= $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Election
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description_tally
     *
     * @param string $description_tally
     * @return Election
     */
    public function setDescriptionTally($description_tally)
    {
        $this->description_tally = $description_tally;

        return $this;
    }

    /**
     * Get description_tally
     *
     * @return string
     */
    public function getDescriptionTally()
    {
        return $this->description_tally;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     * @return Election
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return Election
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set minCandidates
     *
     * @param integer $minCandidates
     * @return Election
     */
    public function setMinCandidates($minCandidates)
    {
        $this->minCandidates = $minCandidates;

        return $this;
    }

    /**
     * Get minCandidates
     *
     * @return integer 
     */
    public function getMinCandidates()
    {
        return $this->minCandidates;
    }

    /**
     * Set maxCandidates
     *
     * @param integer $maxCandidates
     * @return Election
     */
    public function setMaxCandidates($maxCandidates)
    {
        $this->maxCandidates = $maxCandidates;

        return $this;
    }

    /**
     * Get maxCandidates
     *
     * @return integer 
     */
    public function getMaxCandidates()
    {
        return $this->maxCandidates;
    }

    /**
     * Set publishResults
     *
     * @param boolean $publishResults
     * @return Election
     */
    public function setPublishResults($publishResults)
    {
        $this->publishResults = $publishResults;

        return $this;
    }

    /**
     * Get publishResults
     *
     * @return boolean 
     */
    public function getPublishResults()
    {
        return $this->publishResults;
    }

    /**
     * Set datePublished
     *
     * @param \DateTime $datePublished
     * @return Election
     */
    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    /**
     * Get datePublished
     *
     * @return \DateTime 
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }
}

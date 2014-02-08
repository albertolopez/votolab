<?php

namespace Votolab\VotolabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Election
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Election
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
     * @ORM\ManyToMany(targetEntity="Votolab\UserBundle\Entity\User", mappedBy="elections")
     **/
    private $users;

    public function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set alias
     *
     * @param string $alias
     * @return Election
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
}

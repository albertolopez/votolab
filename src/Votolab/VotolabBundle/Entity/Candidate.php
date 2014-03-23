<?php

namespace Votolab\VotolabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vlabs\MediaBundle\Annotation\Vlabs;

/**
 * Candidate
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Candidate
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
     * @ORM\ManyToOne(targetEntity="Votolab\VotolabBundle\Entity\Election", inversedBy="candidates")
     */
    private $election;

    /**
     * @ORM\OneToMany(targetEntity="Votolab\VotolabBundle\Entity\Vote", mappedBy="candidate", cascade={"remove"})
     */
    private $votes;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="biography", type="text")
     */
    private $biography;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="text")
     */
    private $video;

    /**
     * @var string
     *
     * @ORM\Column(name="video2", type="text")
     */
    private $video2;


    /**
     * @var integer
     *
     * @ORM\Column(name="gender", type="boolean")
     */
    private $gender;

    /**
     * @var VlabsFile
     *
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"}, orphanRemoval=true))
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image", referencedColumnName="id")
     * })
     *
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="competence", type="string", length=255)
     */
    private $competence;

    /**
     * @var string
     *
     * @ORM\Column(name="original_list", type="string")
     */
    private $original_list;

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
     * Set election
     *
     * @param Election $election
     */
    public function setElection(Election $election)
    {
        $this->election = $election;
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
     * Set name
     *
     * @param string $name
     * @return Candidate
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set biography
     *
     * @param string $biography
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;
    }

    /**
     * Get biography
     *
     * @return string
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Set video
     *
     * @param string $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set video2
     *
     * @param string $video2
     */
    public function setVideo2($video2)
    {
        $this->video2 = $video2;
    }

    /**
     * Get video2
     *
     * @return string
     */
    public function getVideo2()
    {
        return $this->video2;
    }

    /**
     * Set gender
     *
     * @param boolean $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Get gender
     *
     * @return boolean
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set image
     *
     * @param Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImagePath($imagePath)
    {
        $image = new Image();
        $image->setName(str_replace('files/images/', '', $imagePath));
        $image->setPath($imagePath);
        $image->setContentType('image/jpeg');
        $image->setSize(filesize($imagePath));
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return Image $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get image path
     *
     * @return string $image
     */
    public function getImagePath()
    {
        if (!empty($this->image)) {
            return $this->image->getPath();
        } else {
            return null;
        }
    }

    /**
     * Set competence
     *
     * @param string $competence
     */
    public function setCompetence($competence)
    {
        $this->competence = $competence;
    }

    /**
     * Get competence
     *
     * @return string
     */
    public function getCompetence()
    {
        return $this->competence;
    }

    /**
     * Set original list
     *
     * @param string $original_list
     */
    public function setOriginalList($originalList)
    {
        $this->original_list = $originalList;
    }

    /**
     * Get original list
     *
     * @return string
     */
    public function getOriginalList()
    {
        return $this->original_list;
    }
}

<?php
// src/Votolab/UserBundle/Entity/User.php

namespace Votolab\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Votolab\VotolabBundle\Entity\Election;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Votolab\VotolabBundle\Entity\Election", inversedBy="voters")
     * @ORM\JoinTable(name="election_users")
     **/
    private $elections;

    /**
     * @var integer
     *
     * @ORM\Column(name="welcomeSent", type="boolean")
     */
    private $welcomeSent = false;

    public function __construct() {
        parent::__construct();
        $this->elections = new ArrayCollection();
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Election $election
     */
    public function addElection(Election $election)
    {
        $this->elections[] = $election;
    }

    /**
     * @return mixed
     */
    public function getElections()
    {
        return $this->elections;
    }

    /**
     * @param mixed $welcomeSent
     */
    public function setWelcomeSent($welcomeSent)
    {
        $this->welcomeSent = $welcomeSent;
    }

    /**
     * @return mixed
     */
    public function getWelcomeSent()
    {
        return $this->welcomeSent;
    }
}

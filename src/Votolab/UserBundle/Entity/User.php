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
}

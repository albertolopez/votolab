<?php
// src/Votolab/UserBundle/Entity/User.php

namespace Votolab\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToMany(targetEntity="Votolab\VotolabBundle\Entity\Election", inversedBy="users")
     * @ORM\JoinTable(name="Voters")
     **/
    private $elections;

    public function __construct() {
        parent::__construct();
        $this->elections = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

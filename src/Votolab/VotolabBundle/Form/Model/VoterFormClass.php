<?php
namespace Votolab\VotolabBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Votolab\UserBundle\Entity\User;
use Votolab\VotolabBundle\Entity\Election;

class VoterFormClass
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @Assert\NotBlank(message="Email es obligatorio")
     * @Assert\Email(message="El email no es valido")
     * @var string
     */
    public $email;
    /**
     * @Assert\NotBlank(message="El nombre de usuario es obligatorio")

    /**
     * @var Election
     */
    public $election;

    public function __construct(User $user, Election $election)
    {
        $this->id = $user->getId();
        $this->email = $user->getEmail();
        $this->username = $user->getUsername();
        $this->election = $election;
    }
}
<?php

namespace Votolab\VotolabBundle\Voters;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Votolab\VotolabBundle\Entity\Election;
use Votolab\VotolabBundle\Model\ElectionManager;

class CanViewTallyVoter implements VoterInterface
{
    /** @var ElectionManager */
    protected $electionManager;

    /**
     * @param $electionManager
     */
    public function __construct(ElectionManager $electionManager)
    {
        $this->electionManager = $electionManager;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsAttribute($attribute)
    {
        return 'CAN_VIEW_TALLY' === $attribute;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return get_class($class) === 'Votolab\VotolabBundle\Entity\Election';
    }

    /**
     * {@inheritDoc}
     */
    public function vote(TokenInterface $token, $election, array $attributes)
    {
        foreach ($attributes as $attribute) {
            if ($this->supportsAttribute($attribute) && $this->supportsClass($election)) {
                $user = $token->getUser();
                if ((in_array($election->getStatus(), array(Election::STATUS_PUBLISHED)) && $this->electionManager->isVoterForElection($user, $election)) || $token->getUser()->hasRole('ROLE_SUPER_ADMIN')) {
                    return VoterInterface::ACCESS_GRANTED;
                }
            }
        }
        return VoterInterface::ACCESS_DENIED;
    }
}
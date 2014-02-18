<?php

namespace Votolab\VotolabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use Votolab\VotolabBundle\Entity\Election;

class ElectionsController extends Controller
{

    /**
     * @template
     */
    public function electionsAction()
    {
        $user = $this->getUser();
        $electionManager = $this->get('election_manager');
        return array(
            'elections' => $electionManager->findForUser($user),
            'electionsPast' => $electionManager->findForUserPast($user)
        );
    }

    /**
     * @template
     * @SecureParam(name="election", permissions="CAN_VIEW_ELECTION")
     */
    public function electionAction(Election $election)
    {
        $candidateManager = $this->get('candidate_manager');
        return array(
            'election' => $election,
            'candidates' => $candidateManager->findByElectionOrderRandom($election),
            'criteria' => $election->getElectionCriteria()
        );
    }

    /**
     * @template
     * @SecureParam(name="election", permissions="CAN_VIEW_ELECTION")
     */
    public function tallyAction(Election $election)
    {
        if ($election->getDateEnd() > new \DateTime('now')) {
            return $this->redirect($this->generateUrl('votolab_elections'));
        }
        $candidateManager = $this->get('candidate_manager');
        $electionManager = $this->get('election_manager');

        return array(
            'election' => $election,
            'candidates' => $candidateManager->findByElectionOrderRandom($election),
            'criteria' => $election->getElectionCriteria(),
            'tally' => $electionManager->getElectionTally($election)
        );
    }

    /**
     * @template
     */
    public function voteAction()
    {

    }
}
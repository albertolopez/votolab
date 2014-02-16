<?php

namespace Votolab\VotolabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
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
        $repository = $this->getDoctrine()->getRepository('VotolabBundle:Candidate');
        $candidates = $repository->findByElection($election);
        shuffle($candidates);

        return array('election' => $election, 'candidates' => $candidates, 'criteria' => $election->getElectionCriteria());
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
        $electionManager = $this->get('election_manager');
        $repository = $this->getDoctrine()->getRepository('VotolabBundle:Candidate');
        $candidates = $repository->findByElection($election);
        $tally = $electionManager->getElectionTally($election);

        return array('election' => $election, 'candidates' => $candidates, 'criteria' => $election->getElectionCriteria(), 'tally' => $tally);
    }

    /**
     * @template
     */
    public function voteAction()
    {

    }
}
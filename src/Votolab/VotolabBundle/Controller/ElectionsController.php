<?php

namespace Votolab\VotolabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
        return array('elections' => $electionManager->findForUser($user));
    }

    /**
     * @template
     */
    public function electionAction(Election $election)
    {
        $user = $this->getUser();
        $electionManager = $this->get('election_manager');

        $isVoter = $electionManager->isVoterForElection($user, $election);
        if (empty($isVoter)) {
            return $this->redirect($this->generateUrl('votolab_elections'));
        }

        $repository = $this->getDoctrine()->getRepository('VotolabBundle:Candidate');
        $candidates = $repository->findByElectionId($election->getId());

        return array('election' => $election, 'candidates' => $candidates);
    }
}
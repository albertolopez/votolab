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
     * @SecureParam(name="election", permissions="CAN_VIEW_ELECTION")
     */
    public function listTalliesAction(Election $election)
    {
        if ($election->getDateEnd() > new \DateTime('now')) {
            return $this->redirect($this->generateUrl('votolab_elections'));
        }

        $voteManager = $this->get('vote_manager');

        return array(
            'votes' => $voteManager->findByElection($election)
        );
    }

    /**
     * @template
     * @SecureParam(name="election", permissions="CAN_VIEW_ELECTION")
     */
    public function viewTallyAction(Election $election, User $user, Candidate $candidate)
    {
        //$candidateManager = $this->get('candidate_manager');
        //$electionManager = $this->get('election_manager');
        //Election $election;
        $votes = "";

        return array(
            'election' => $election,
            'candidate' => $candidate,
            'votes' => $votes
        );
    }

    /**
     * @template
     */
    public function voteAction(Election $election, Candidate $candidate)
    {
        //TODO:
        //sendVoteEmail($candidate, $user, $votes);
    }

    private function sendVoteEmail(Candidate $candidate, User $user, $votes)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Voto Emitido')
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'VotolabBundle:Mails:vote.txt.twig',
                    array('user'=> $user, 'candidate' => $candidate, 'votes' => $votes)
                )
            )
        ;
        $this->mailer->send($message);
    }

}
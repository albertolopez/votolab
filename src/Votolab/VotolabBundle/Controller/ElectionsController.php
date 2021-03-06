<?php

namespace Votolab\VotolabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Votolab\UserBundle\Entity\User;
use Votolab\VotolabBundle\Entity\Candidate;
use Votolab\VotolabBundle\Entity\Election;
use Votolab\VotolabBundle\Entity\Vote;


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
            'elections' => $electionManager->findForUserByStatus(
                    $user,
                    array(Election::STATUS_OPEN, Election::STATUS_PREVIEW)
                ),
            'electionsPast' => $electionManager->findForUserByStatus(
                    $user,
                    array(Election::STATUS_PUBLISHED, Election::STATUS_CLOSED)
                ),
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
     */
    public function ep2014Action()
    {
        $candidateManager = $this->get('candidate_manager');
        $em = $this->container->get('doctrine')->getManager();
        $election = $em->getRepository('VotolabBundle:Election')->findOneBy(array('slug' => 'europeas-2014'));
        return $this->render(
            'VotolabBundle:Elections:candidates.html.twig',
            array(
                'election' => $election,
                'candidates' => $candidateManager->findByElectionOrderRandom($election),
                'criteria' => $election->getElectionCriteria()
            )
        );
    }

    /**
     * @template
     * @SecureParam(name="election", permissions="CAN_VIEW_TALLY")
     */
    public function tallyAction(Election $election)
    {
        $electionManager = $this->get('election_manager');

        return array(
            'election' => $election,
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

        //$voteManager = $this->get('vote_manager');

        //return array(
        //    'votes' => $voteManager->findByElection($election)
        //);

        $em = $this->get('doctrine.orm.entity_manager');
        $q = $em->createQuery(
            'select v from Votolab\VotolabBundle\Entity\Vote v
                        left join v.candidate c
                        where v.election = :election order by c.name asc'
        );
        $q->setParameter('election', $election);

        $paginator = $this->get('knp_paginator');
        $votes = $paginator->paginate(
            $q,
            $this->get('request')->query->get('page', 1),
            $this->container->getParameter('page_range')
        );

        return $this->render('VotolabBundle:Elections:listTallies.html.twig', array('votes' => $votes));
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
     * @param $ratings
     * @param Election $election
     * @param $candidate
     */
    private function validateVote($ratings, $election, $candidate)
    {
        $user = $this->getUser();
        $em = $this->container->get('doctrine')->getManager();
        $votes = $em->getRepository('VotolabBundle:Vote')->findBy(
            array(
                'election' => $election,
                'candidate' => $candidate,
                'user' => $user
            )
        );
        if (count($votes) > $election->getMaxCandidates()) {
            return false;
        }
        foreach ($ratings as $rating) {
            $electionCriteria = $em->getRepository('VotolabBundle:ElectionCriteria')->find($rating['index']);
            if ($rating['value'] > $electionCriteria->getMax() || $rating['value'] < $electionCriteria->getMin()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @template
     * @SecureParam(name="election", permissions="CAN_VOTE_ELECTION")
     */
    public function voteAction(Request $request, Election $election)
    {
        $ratings = $request->get('ratings');
        $em = $this->container->get('doctrine')->getManager();
        $candidate = $em->getRepository('VotolabBundle:Candidate')->find($request->get('candidateId'));
        if (!$this->validateVote($ratings, $election, $candidate)) {
            $response = array("error" => true, "message" => 'invalid vote');
            return new Response(json_encode($response));
        }
        foreach ($ratings as $rating) {
            $electionCriteria = $em->getRepository('VotolabBundle:ElectionCriteria')->find($rating['index']);
            $vote = $em->getRepository('VotolabBundle:Vote')->find(
                array(
                    'election' => $election->getId(),
                    'candidate' => $candidate->getId(),
                    'user' => $this->getUser()->getId(),
                    'criterion' => $electionCriteria->getId()
                )
            );
            if (empty($vote)) {
                $vote = new Vote();
                $vote->setElection($election);
                $vote->setCandidate($candidate);
                $vote->setCriterion($electionCriteria);
                $vote->setUser($this->getUser());
            }
            $vote->setVote($rating['value']);
            $vote->setVotedAt(new \DateTime(date('Y-m-d H:i:s')));
            $em->persist($vote);
            $em->flush();
        }

        $response = array("success" => true);
        return new Response(json_encode($response));
    }

    /**
     * @template
     */
    private function sendVoteEmail(Election $election, Candidate $candidate)
    {

        $user = $this->getUser();
        $message = \Swift_Message::newInstance()
            ->setSubject('Voto Emitido')
            ->setFrom($this->container->getParameter('mailer_user'))
            ->setTo($user->getEmail())
            ->setBody(
                'Tu voto ha sido registrado.'
            );
        $this->mailer->send($message);
    }

}
<?php

namespace Votolab\VotolabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Votolab\VotolabBundle\Entity\Election;

class ElectionsController extends Controller
{

    public function electionsAction()
    {
        return $this->render('VotolabBundle:Elections:elections.html.twig');
    }

    public function electionAction()
    {
        $electionRepository = $this->getDoctrine()->getRepository('VotolabBundle:Election');
        $election = $electionRepository->findOneByAlias('listas-abiertas-europeas-2014');

        /*if (empty($election)) {
            return $this->redirect($this->generateUrl('votolab_elections'));
        }*/

        $user = $this->getUser();

        /*$voterRepository = $this->getDoctrine()->getRepository('VotolabBundle:Voter');
        $election = $voterRepository->findOneBy('listas-abiertas-europeas-2014');*/

        return $this->render('VotolabBundle:Elections:election.html.twig', array('election' => $election));
    }

}
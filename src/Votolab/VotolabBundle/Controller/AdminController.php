<?php

namespace Votolab\VotolabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Votolab\VotolabBundle\Entity\Election;

class AdminController extends Controller
{

    /**
     * @template
     */
    public function dashboardAction()
    {
        $electionsManager = $this->get('election_manager');
        $elections = $electionsManager->findAllElections();
        return array('elections' => $elections);
    }

    /**
     * @template
     */
    public function addElectionsAction()
    {
        return array();
    }

    /**
     * @template
     */
    public function editElectionsAction(Election $election)
    {
        return array('election' => $election);
    }

    /**
     * @template
     */
    public function deleteElectionsAction(Election $election)
    {
        $electionsManager = $this->get('election_manager');
        $electionsManager->removeElection($election);
        $this->redirect($this->generateUrl('votolab_admin'));
    }

}
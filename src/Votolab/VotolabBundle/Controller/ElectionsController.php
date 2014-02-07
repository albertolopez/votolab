<?php

namespace Votolab\VotolabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ElectionsController extends Controller
{

    public function electionsAction()
    {
        return $this->render('VotolabBundle:Elections:elections.html.twig');
    }

    public function electionAction()
    {
        return $this->render('VotolabBundle:Elections:election.html.twig');
    }

}
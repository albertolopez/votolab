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
        return array();
    }

    /**
     * @template
     */
    public function electionsAdminAction()
    {
        return array();
    }

}
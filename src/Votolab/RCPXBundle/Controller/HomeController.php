<?php

namespace Votolab\RCPXBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
        if (!empty($user)) {
            return $this->redirect($this->generateUrl('votolab_elections'));
        }
        
        return $this->render('RCPXBundle:Home:index.html.twig');
    }
}

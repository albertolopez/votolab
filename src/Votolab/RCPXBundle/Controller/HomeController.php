<?php

namespace Votolab\RCPXBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('RCPXBundle:Home:index.html.twig');
    }
}

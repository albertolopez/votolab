<?php

namespace Votolab\VotolabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Votolab\VotolabBundle\Entity\Election;
use Votolab\VotolabBundle\Form\Handler\ElectionFormHandler;
use Votolab\VotolabBundle\Form\Model\ElectionFormClass;
use Symfony\Component\Form\Form;

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
    public function addElectionsAction(Request $request)
    {
        $election = new Election();
        return $this->createOrEditProject($request, $election);
    }

    /**
     * @template
     */
    public function editElectionsAction(Request $request, Election $election)
    {
        return $this->createOrEditProject($request, $election);
    }

    /**
     * @param Request $request
     * @param Election $election
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function createOrEditProject(Request $request, $election)
    {
        $form = $this->createForm('election', new ElectionFormClass($election));
        if ($request->getMethod() == "POST") {
            $formHandler = new ElectionFormHandler($form, $request, $this->get('election_manager'));
            if ($formHandler->process()) {
                $this->get('session')->getFlashBag()->set(
                    'notice',
                    "La elección <b>{$form->getData()->title}</b> ha sido creada"
                );
                return $this->redirect($this->generateUrl('votolab_admin'));
            }
        }

        return $this->render(
            'VotolabBundle:Admin:addElections.html.twig',
            array(
                'election' => $election,
                'form' => $form->createView(),
            )
        );
    }

    public function deleteElectionsAction(Election $election)
    {
        $electionsManager = $this->get('election_manager');
        $electionsManager->removeElection($election);
        $this->redirect($this->generateUrl('votolab_admin'));
    }
}
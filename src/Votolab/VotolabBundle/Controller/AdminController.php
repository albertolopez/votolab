<?php

namespace Votolab\VotolabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Votolab\VotolabBundle\Entity\Candidate;
use Votolab\VotolabBundle\Entity\Election;
use Votolab\VotolabBundle\Form\Handler\CandidateFormHandler;
use Votolab\VotolabBundle\Form\Handler\ElectionFormHandler;
use Votolab\VotolabBundle\Form\Model\CandidateFormClass;
use Votolab\VotolabBundle\Form\Model\ElectionFormClass;

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
        return $this->createOrEditElection($request, $election);
    }

    /**
     * @template
     */
    public function editElectionsAction(Request $request, Election $election)
    {
        return $this->createOrEditElection($request, $election);
    }

    /**
     * @param Request $request
     * @param Election $election
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function createOrEditElection(Request $request, Election $election)
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
        return $this->redirect($this->generateUrl('votolab_admin'));
    }


    ///////////////////////////// CANDIDATES /////////////////////////////////////////
    /**
     * @template
     */
    public function addCandidateAction(Request $request)
    {
        $candidate = new Candidate();
        return $this->createOrEditCandidate($request, $candidate);
    }

    /**
     * @template
     */
    public function editCandidateAction(Request $request, Candidate $candidate)
    {
        return $this->createOrEditCandidate($request, $candidate);
    }

    /**
     * @param Request $request
     * @param Candidate $candidate
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function createOrEditCandidate(Request $request, Candidate $candidate)
    {
        $form = $this->createForm('candidate', new CandidateFormClass($candidate));
        if ($request->getMethod() == "POST") {
            $formHandler = new CandidateFormHandler($form, $request, $this->get('candidate_manager'));
            if ($formHandler->process()) {
                $this->get('session')->getFlashBag()->set(
                    'notice',
                    "El candidato <b>{$form->getData()->title}</b> ha sido creado"
                );
                return $this->redirect($this->generateUrl('votolab_admin'));
            }
        }

        return $this->render(
            'VotolabBundle:Admin:addCandidate.html.twig',
            array(
                'candidate' => $candidate,
                'form' => $form->createView(),
            )
        );
    }

    public function deleteCandidateAction(Candidate $candidate)
    {
        $electionsManager = $this->get('candidate_manager');
        $electionsManager->removeElection($candidate);
        return $this->redirect($this->generateUrl('votolab_admin'));
    }

}
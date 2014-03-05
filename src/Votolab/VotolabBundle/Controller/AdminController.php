<?php

namespace Votolab\VotolabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Votolab\VotolabBundle\Entity\Candidate;
use Votolab\VotolabBundle\Entity\Election;
use Votolab\VotolabBundle\Entity\ElectionCriteria;
use Votolab\VotolabBundle\Event\ElectionEvent;
use Votolab\VotolabBundle\Form\Handler\CandidateFormHandler;
use Votolab\VotolabBundle\Form\Handler\CriteriaFormHandler;
use Votolab\VotolabBundle\Form\Handler\ElectionFormHandler;
use Votolab\VotolabBundle\Form\Handler\VoterFormHandler;
use Votolab\VotolabBundle\Form\Handler\ImportVotersFormHandler;
use Votolab\VotolabBundle\Form\Model\CandidateFormClass;
use Votolab\VotolabBundle\Form\Model\CriteriaFormClass;
use Votolab\VotolabBundle\Form\Model\ElectionFormClass;
use Votolab\VotolabBundle\Form\Model\VoterFormClass;
use Votolab\VotolabBundle\Form\Model\ImportVotersFormClass;
use Votolab\VotolabBundle\VotolabEvents;
use Votolab\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

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
                    "La elección {$form->getData()->title} ha sido creada/modificada"
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
        $electionsManager->remove($election);
        return $this->redirect($this->generateUrl('votolab_admin'));
    }

    public function publishElectionAction(Election $election)
    {
        $event = new ElectionEvent($election);
        $electionsManager = $this->get('election_manager');
        $electionsManager->publish($election);
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch(VotolabEvents::ELECTION_PUBLISHED, $event);
        $this->get('session')->getFlashBag()->set(
            'notice',
            "La elección {$election->getTitle()} ha sido publicada"
        );
        return $this->redirect($this->generateUrl('votolab_admin'));
    }


    ///////////////////////////// CANDIDATES /////////////////////////////////////////

    /**
     * @template
     */
    public function listCandidatesAction(Election $election)
    {
        return array('candidates' => $election->getCandidates(), 'election' => $election);
    }

    /**
     * @template
     */
    public function addCandidateAction(Request $request, Election $election)
    {
        $candidate = new Candidate();
        return $this->createOrEditCandidate($request, $election, $candidate);
    }

    /**
     * @template
     * @ParamConverter("election", options={"mapping": {"slug": "slug"}})
     */
    public function editCandidateAction(Request $request, Election $election, Candidate $candidate)
    {
        return $this->createOrEditCandidate($request, $election, $candidate);
    }

    /**
     * @param Request $request
     * @param Candidate $candidate
     * @param \Votolab\VotolabBundle\Entity\Election $election
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function createOrEditCandidate(Request $request, Election $election, Candidate $candidate)
    {
        $candidate->setElection($election);
        $form = $this->createForm('candidate', new CandidateFormClass($candidate));
        if ($request->getMethod() == "POST") {
            $formHandler = new CandidateFormHandler($form, $request, $this->get('candidate_manager'));
            if ($formHandler->process()) {
                $this->get('session')->getFlashBag()->set(
                    'notice',
                    "El candidato {$form->getData()->name} ha sido creado/modificado"
                );
                return $this->redirect(
                    $this->generateUrl('votolab_list_candidates', array('slug' => $election->getSlug()))
                );
            }
        }

        return $this->render(
            'VotolabBundle:Admin:addCandidate.html.twig',
            array(
                'candidate' => $candidate,
                'election' => $election,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @ParamConverter("election", options={"mapping": {"slug": "slug"}})
     */
    public function deleteCandidateAction(Election $election, Candidate $candidate)
    {
        $electionsManager = $this->get('candidate_manager');
        $electionsManager->remove($candidate);
        return $this->redirect($this->generateUrl('votolab_list_candidates', array('slug' => $election->getSlug())));
    }

    ///////////////////////////// CANDIDATES /////////////////////////////////////////

    /**
     * @template
     */
    public function listCriteriasAction(Election $election)
    {
        return array('criterias' => $election->getElectionCriteria(), 'election' => $election);
    }

    /**
     * @template
     */
    public function addCriteriaAction(Request $request, Election $election)
    {
        $criteria = new ElectionCriteria();
        return $this->createOrEditCriteria($request, $election, $criteria);
    }

    /**
     * @template
     * @ParamConverter("election", options={"mapping": {"slug": "slug"}})
     */
    public function editCriteriaAction(Request $request, Election $election, ElectionCriteria $criteria)
    {
        return $this->createOrEditCriteria($request, $election, $criteria);
    }

    /**
     * @param Request $request
     * @param ElectionCriteria $criteria
     * @param \Votolab\VotolabBundle\Entity\Election $election
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function createOrEditCriteria(Request $request, Election $election, ElectionCriteria $criteria)
    {
        $criteria->setElection($election);
        $form = $this->createForm('criteria', new CriteriaFormClass($criteria));
        if ($request->getMethod() == "POST") {
            $formHandler = new CriteriaFormHandler($form, $request, $this->get('criteria_manager'));
            if ($formHandler->process()) {
                $this->get('session')->getFlashBag()->set(
                    'notice',
                    "El criterio {$form->getData()->criterion} ha sido creado/modificado"
                );
                return $this->redirect(
                    $this->generateUrl('votolab_list_criterias', array('slug' => $election->getSlug()))
                );
            }
        }

        return $this->render(
            'VotolabBundle:Admin:addCriteria.html.twig',
            array(
                'criteria' => $criteria,
                'election' => $election,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @ParamConverter("election", options={"mapping": {"slug": "slug"}})
     */
    public function deleteCriteriaAction(Election $election, ElectionCriteria $criteria)
    {
        $criteriaManager = $this->get('criteria_manager');
        $criteriaManager->remove($criteria);
        return $this->redirect($this->generateUrl('votolab_list_criterias', array('slug' => $election->getSlug())));
    }

    /**
     * @template
     */
    public function listVotersAction(Election $election)
    {
        return array('election' => $election);
    }

    /**
     * @template
     */
    public function addVoterAction(Request $request, Election $election)
    {
        $user = new User();
        return $this->createOrEditUser($request, $election, $user);
    }

    /**
     * @template
     * @ParamConverter("election", options={"mapping": {"slug": "slug"}})
     */
    public function editVoterAction(Request $request, Election $election, User $user)
    {
        return $this->createOrEditUser($request, $election, $user);
    }

    /**
     * @param Request $request
     * @param \Votolab\VotolabBundle\Entity\Election $election
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function createOrEditUser(Request $request, Election $election, User $user)
    {
        $form = $this->createForm('user', new VoterFormClass($user, $election));
        if ($request->getMethod() == "POST") {
            $formHandler = new VoterFormHandler($form, $request, $this->get('fos_user.user_manager'));
            if ($formHandler->process()) {
                $this->get('session')->getFlashBag()->set(
                    'notice',
                    "El usuario {$form->getData()->email} ha sido creado/modificado"
                );
                return $this->redirect(
                    $this->generateUrl('votolab_list_voters', array('slug' => $election->getSlug()))
                );
            }
        }
        return $this->render(
            'VotolabBundle:Admin:addVoter.html.twig',
            array(
                'election' => $election,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @template
     */
    public function importVoterAction(Request $request, Election $election)
    {
        $form = $this->createForm('importvoters', new ImportVotersFormClass($election));
        if ($request->getMethod() == "POST") {
            $formHandler = new ImportVotersFormHandler($form, $request, $this->get('fos_user.user_manager'));
            if ($formHandler->process()) {
                $this->get('session')->getFlashBag()->set(
                    'notice',
                    "Los votantes han sido incluidos en la elección"
                );
                return $this->redirect(
                    $this->generateUrl('votolab_list_voters', array('slug' => $election->getSlug()))
                );
            }
        }

        return $this->render(
            'VotolabBundle:Admin:importVoters.html.twig',
            array(
                'election' => $election,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @ParamConverter("election", options={"mapping": {"slug": "slug"}})
     */
    public function deleteVoterAction(Election $election, User $user)
    {
        $electionManager = $this->get('election_manager');
        $electionManager->removeVoter($election, $user);
        return $this->redirect($this->generateUrl('votolab_list_voters', array('slug' => $election->getSlug())));
    }

}
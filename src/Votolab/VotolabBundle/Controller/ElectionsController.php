<?php

namespace Votolab\VotolabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ElectionsController extends Controller
{

    public function electionsAction()
    {
        $user = $this->getUser();

        $query = $this->getDoctrine()->getManager()
            ->createQuery('
                SELECT e FROM Votolab\VotolabBundle\Entity\Election e
                LEFT JOIN e.voters v
                WHERE e.dateStart < CURRENT_TIMESTAMP() AND e.dateEnd > CURRENT_TIMESTAMP()
                AND v.id = :user'
            )->setParameter('user', $user->getId());

        $elections = $query->execute();

        return $this->render(
            'VotolabBundle:Elections:elections.html.twig',
            array(
                'elections' => $elections
            )
        );
    }

    public function electionAction($slug)
    {
        $user = $this->getUser();

        $query = $this->getDoctrine()->getManager()
            ->createQuery('
                SELECT e FROM Votolab\VotolabBundle\Entity\Election e
                LEFT JOIN e.voters v
                WHERE e.dateStart < CURRENT_TIMESTAMP() AND e.dateEnd > CURRENT_TIMESTAMP()
                AND v.id = :user AND e.slug = :slug'
            )->setParameter('user', $user->getId())
            ->setParameter('slug', $slug)
            ->setMaxResults(1);
        $election = $query->execute();

        if (empty($election)) {
            return $this->redirect($this->generateUrl('votolab_elections'));
        }

        $election= reset($election);

        $repository = $this->getDoctrine()->getRepository('VotolabBundle:Candidate');
        $candidates = $repository->findByElectionId($election->getId());

        return $this->render('VotolabBundle:Elections:election.html.twig', array(
                'election' => $election,
                'candidates' => $candidates
            )
        );
    }

}
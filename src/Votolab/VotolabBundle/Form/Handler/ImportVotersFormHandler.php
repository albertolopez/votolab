<?php

namespace Votolab\VotolabBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Votolab\VotolabBundle\Model\VoterManager;

class ImportVotersFormHandler
{
    protected $form;

    protected $request;

    protected $em;

    public function __construct(FormInterface $form, Request $request, VoterManager $manager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->manager = $manager;
    }

    public function process()
    {
        $this->form->handleRequest($this->request);
        if ($this->form->isValid()) {
            return $this->manager->createImport($this->form->getData());
        }
        return false;
    }
}
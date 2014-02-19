<?php

namespace Votolab\VotolabBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Votolab\VotolabBundle\Event\ElectionEvent;
use Votolab\VotolabBundle\VotolabEvents;

/**
 * Blames a comment using Symfony2 security component
 *
 */
class PublishResultsElectionListener implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    /**
     * @param ElectionEvent $event
     * @throws \LogicException
     */
    public function onElectionPublish(ElectionEvent $event)
    {
        $election = $event->getElection();

        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody(
                $this->renderView(
                    'VotolabBundle:Mails:election_published.txt.twig',
                    array('election' => $election)
                )
            )
        ;
        $this->mailer->send($message);
    }

    public static function getSubscribedEvents()
    {
        return array(VotolabEvents::ELECTION_PUBLISHED => 'onElectionPublish');
    }
}
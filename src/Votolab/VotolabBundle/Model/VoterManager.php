<?php

namespace Votolab\VotolabBundle\Model;

use Votolab\UserBundle\Entity\User;
use Votolab\VotolabBundle\Form\Model\ImportVotersFormClass;
use Votolab\VotolabBundle\Form\Model\VoterFormClass;

/**
 * voter_manager
 */
class VoterManager extends ManagerAbstract{


    public function create(VoterFormClass $voterFormClass)
    {
        $userList = $this->em->getRepository('UserBundle:User')->findBy(array('email' => $voterFormClass->email));
        $user = NULL;
        if (is_null($userList) || count($userList) == 0){
            $user = new User();
            $user->setEnabled(true);
            $user->setLocked(false);
            $user->setPlainPassword($voterFormClass->email);
            $user->setUsernameCanonical($voterFormClass->email);
            $user->setEmailCanonical($voterFormClass->email);
            $user->setEmail($voterFormClass->email);
            $user->setUsername($voterFormClass->email);
        }
        else{
            $user = $userList[0];
        }
        if ($this->isUserInElection($user, $voterFormClass->election) == false){
            $user->addElection($voterFormClass->election);
        }
        $this->em->persist($user);
        $this->em->flush();
        return true;

    }

    public function createImport(ImportVotersFormClass $importVotersFormClass)
    {
        $userList = explode(PHP_EOL, $importVotersFormClass->voters);
        if (count($userList) > 0){
            $this->addVotersToElection($userList, $importVotersFormClass->election);
        }

        //for uploaded files
        //$userList = Array();
        //$file = $importVotersFormClass->attachment->getData()->openFile('r');
        //if(!is_null($file)){
        //    $userList[] = $file->current();
        //    $file->next();
        //}
        //if (count($userList) > 0){
        //    $this->addVotersToElection($userList, $importVotersFormClass->election);
        //}

        return true;
    }

    public function addVotersToElection($userList, $election)
    {
        foreach($userList as $email)
        {
            if ($email != "")
            {
                $email = trim($email);
                $user = NULL;
                $users = $this->em->getRepository('UserBundle:User')->findBy(array('email' => $email));
                if (is_null($users) || count($users) == 0){
                    $user = new User();
                    $user->setEnabled(true);
                    $user->setLocked(false);
                    $user->setPlainPassword($email);
                    $user->setUsernameCanonical($email);
                    $user->setEmailCanonical($email);
                    $user->setEmail($email);
                    $user->setUsername($email);
                }
                else{
                    $user = $users[0];
                }
                if (!$this->isUserInElection($user, $election)){
                    $user->addElection($election);
                }
                $this->em->persist($user);
                $this->em->flush();
            }
        }
    }

    public function isUserInElection(User $user, $election)
    {
        $isUserInElection = false;
        if (!is_null($user->getElections() && count($user->getElections()) != 0)){
            foreach($user->getElections() as $e)
            {
                if ($election == $e){
                    $isUserInElection = true;
                    break;
                }
            }
        }
        return $isUserInElection;
    }

}


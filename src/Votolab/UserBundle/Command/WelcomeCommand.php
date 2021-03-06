<?php
namespace Votolab\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WelcomeCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('votolab:welcome')
            ->setDescription('Welcome someone')
            ->addArgument('email', InputArgument::OPTIONAL, '¿A quien quieres dar la bienvenida?')//->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $container = $this->getApplication()->getKernel()->getContainer();
        $userManager = $container->get('fos_user.user_manager');
        $user = $userManager->findUserByEmail($email);
        if (!empty($user)) {
            $password = substr($container->get('fos_user.util.token_generator')->generateToken(), 0, 8);
            $user->setPlainPassword($password);
            $user->setWelcomeSent(true);
            $userManager->updateUser($user);
            $message = \Swift_Message::newInstance()
                ->setSubject(' Tu usuario para participar en la votación final de las Listas Abiertas Ciudadanas')
                ->setFrom(array('tech@partidox.org' => 'Red Ciudadana - Partido X'))
                ->setTo($user->getEmail())
                ->setBody($container->get('templating')->render('UserBundle:Email:welcome.html.twig', array('email' => $email, 'password' => $password)), 'text/html' );

            $container->get('mailer')->send($message);
            $output->writeln($email .': Enviado!' );

        } else {
            $output->writeln($email . ': User not found');
        }
    }
}

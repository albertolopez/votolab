<?php
namespace Votolab\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReminderAllCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('votolab:reminder:all')
            ->setDescription('Remind all')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        $container = $this->getApplication()->getKernel()->getContainer();
        $userManager = $container->get('fos_user.user_manager');
        $em = $container->get('doctrine')->getManager()->getRepository('UserBundle:User');
        $users = $em->findByRemindeSent(false);
        if (!empty($users)) {
            foreach ($users as $user) {
                $email = $user->getEmail();
                $password = substr($container->get('fos_user.util.token_generator')->generateToken(), 0, 8);
                $user->setPlainPassword($password);
                $user->setReminderSent(true);
                $userManager->updateUser($user);
                $message = \Swift_Message::newInstance()
                    ->setSubject('¡Todo preparado para el fogueo de mañana sábado 22 de marzo!')
                    ->setFrom(array('tech@partidox.org' => 'Red Ciudadana - Partido X'))
                    ->setTo($user->getEmail())
                    ->setBody($container->get('templating')->render('UserBundle:Email:reminder.html.twig', array('email' => $email, 'password' => $password)), 'text/html');

                $container->get('mailer')->send($message);
                $output->writeln($email . ': Enviado!');
            }

        } else {
            $output->writeln('No new users found');
        }
    }
}

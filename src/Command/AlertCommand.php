<?php

namespace App\Command;

use App\Repository\PublicationRepository;
use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

#[AsCommand(
    name: 'app:alert',
    description: 'Add a short description for your command',
)]
class AlertCommand extends Command
{


    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->userRepository->findAll();
        foreach ($users as $user) {
            $publications = $user->getPublicationsAlert();
            $nbPublication = $publications->count();
            // send email to user
            if ($nbPublication > 0) {
                $email = (new TemplatedEmail())
                    ->from(new Address('admin@exemple.com'))
                    ->to($user->getEmail())
                    ->subject('Vos alertes ('.$nbPublication.')')
                    ->htmlTemplate('email/alert.html.twig')
                    ->context([
                        'user' => $user,
                        'publications' => $publications,
                        'nbPublication' => $nbPublication,
                    ]);
                try {
                    $this->mailer->send($email);
                } catch (TransportExceptionInterface $e) {
                    $this->logger->error($e->getMessage());
                }
            }
        }
        return Command::SUCCESS;
    }
}

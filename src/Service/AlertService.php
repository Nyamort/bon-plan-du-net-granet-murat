<?php

namespace App\Service;

use App\Entity\Publication;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class AlertService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $em
    )
    {
    }

    public function addNotification(Publication $publication): void
    {
        $users =  $this->userRepository->findsubScribeUserToPublication($publication);
        foreach ($users as $user) {
            $user->addPublicationsAlert($publication);
        }
        $this->em->flush();
    }

    public function removeNotification(Publication $publication): void
    {
        $users =  $this->userRepository->findUnsubscribeUserToPublication($publication);
        foreach ($users as $user) {
            $user->removePublicationsAlert($publication);
        }
        $this->em->flush();
    }
}

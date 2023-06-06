<?php

namespace App\Subscriber;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Repository\NotationRepository;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class CommentSubscriber implements EventSubscriberInterface
{


    public function __construct(
        private readonly NotationRepository $notationRepository
    )
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            'prePersist'
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        /**
         * @var Commentaire $entity
         */
        $entity = $args->getObject();

        if (!$entity instanceof Commentaire) {
            return;
        }

        $entity->setPublishedAt(new DateTimeImmutable());
    }
}

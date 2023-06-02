<?php

namespace App\Subscriber;

use App\Entity\Publication;
use App\Repository\NotationRepository;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class PublicationSubscriber implements EventSubscriberInterface
{


    public function __construct(
        private readonly NotationRepository $notationRepository
    )
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            'prePersist',
            'postLoad'
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        /**
         * @var Publication $entity
         */
        $entity = $args->getObject();

        if (!$entity instanceof Publication) {
            return;
        }

        $entity->setPublishedAt(new DateTimeImmutable());
    }

    public function postLoad(LifecycleEventArgs $args): void
    {
        /**
         * @var Publication $entity
         */
        $entity = $args->getObject();

        if (!$entity instanceof Publication) {
            return;
        }

        $notation = intval($this->notationRepository->findByPublication($entity)['value'] ?? 0);
        $entity->setNotation($notation);
    }
}

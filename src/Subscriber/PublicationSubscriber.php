<?php

namespace App\Subscriber;

use App\Entity\Publication;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class PublicationSubscriber implements EventSubscriberInterface
{

    public function getSubscribedEvents(): array
    {
        return [
            'prePersist'
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
}

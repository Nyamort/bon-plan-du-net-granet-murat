<?php

namespace App\Subscriber;

use App\Entity\Notation;
use App\Entity\Publication;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class AlerteSubscriber implements EventSubscriberInterface
{

    public function getSubscribedEvents(): array
    {
        return [
            'postPersist',
            'postRemove'
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if($entity instanceof Notation) {

        }

        if($entity instanceof Publication) {

        }
        return;

    }

    public function postRemove(LifecycleEventArgs $args): void
    {

    }
}

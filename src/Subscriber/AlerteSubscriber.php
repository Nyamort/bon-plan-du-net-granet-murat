<?php

namespace App\Subscriber;

use App\Entity\Notation;
use App\Entity\Publication;
use App\Service\AlertService;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class AlerteSubscriber implements EventSubscriberInterface
{


    public function __construct(
        private readonly AlertService $alertService,
    )
    {
    }

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
            $this->alertService->addNotification($entity->getPublication());
        }

        if($entity instanceof Publication) {
            $this->alertService->addNotification($entity);
        }
        return;

    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if($entity instanceof Notation) {
            $this->alertService->removeNotification($entity->getPublication());
        }
    }
}

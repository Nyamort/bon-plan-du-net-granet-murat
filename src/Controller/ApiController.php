<?php

namespace App\Controller;

use App\Repository\PublicationRepository;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;

#[Route('/api')]
class ApiController extends AbstractFOSRestController
{
    public function __construct(
        private readonly PublicationRepository $publicationRepository
    )
    {
    }

    #[Route('/semaine', name: 'api_semaine')]
    public function aLaUne(): View
    {
        $publications = $this->publicationRepository->findSemaine();

        $groups = ['publication'];
        $context = (new Context())->setGroups($groups);
        return View::create($publications, 200)->setContext($context);
    }
}

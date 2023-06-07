<?php

namespace App\Controller;

use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    public function __construct(
        private PublicationRepository $publicationRepository
    )
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $publications = $this->publicationRepository->findALaUne();

        return $this->render('home/index.html.twig', [
            'publications' => $publications,
        ]);
    }

    #[Route('/hot', name: 'app_hot')]
    public function hot(): Response
    {
        $publications = $this->publicationRepository->findHot();

        return $this->render('home/index.html.twig', [
            'publications' => $publications,
        ]);
    }
}

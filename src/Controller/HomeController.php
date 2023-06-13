<?php

namespace App\Controller;

use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            'page' => 'home'
        ]);
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request): Response
    {
        $search = $request->query->get('search') ?? '';
        $publications = $this->publicationRepository->search($search);

        return $this->render('home/index.html.twig', [
            'publications' => $publications,
            'search' => $search,
            'page' => 'home'
        ]);
    }

    #[Route('/hot', name: 'app_hot')]
    public function hot(): Response
    {
        $publications = $this->publicationRepository->findHot();

        return $this->render('home/index.html.twig', [
            'publications' => $publications,
            'page' => 'hot'
        ]);
    }
}

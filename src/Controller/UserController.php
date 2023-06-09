<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Repository\CommentaireRepository;
use App\Repository\DealRepository;
use App\Repository\PublicationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(PublicationRepository $publicationRepo, CommentaireRepository $commentRepo): Response
    {
        $publication = $publicationRepo->findByUser($this->getUser());
        if ($publication == null)
            $publication = 0;
        $comment = $commentRepo->findByUser($this->getUser());
        if ($comment == null)
            $comment = 0;
        $mostHot = $publicationRepo->findHotByUser($this->getUser());
        if ($mostHot == null)
            $mostHot = 0;
        $average = $publicationRepo->averageNotationByUser($this->getUser());
        if ($average == null)
            $average = 0;
        if($publication>0){
            $pourcentage = $mostHot / $publication * 100;
        }
        else{
            $pourcentage = 0;
        }

        $stats = [
            'publication' => $publication,
            'comment' => $comment,
            'mostHot' => $mostHot,
            'average' => $average,
            'pourcentage' => $pourcentage,
        ];
        return $this->render('user/index.html.twig', [
            'user' => $this->getUser(),
            'stats' => $stats,
        ]);
    }
}

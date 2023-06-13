<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Form\ProfilType;
use App\Form\RegistrationFormType;
use App\Repository\CommentaireRepository;
use App\Repository\DealRepository;
use App\Repository\PublicationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Security('is_granted("ROLE_USER")')]
    #[Route('/user', name: 'app_user')]
    public function index(PublicationRepository $publicationRepo, CommentaireRepository $commentRepo): Response
    {
        $publication = $publicationRepo->countPublicationByUser($this->getUser());
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
        $vote = $publicationRepo->countVoteByUser($this->getUser());

        $stats = [
            'publication' => $publication,
            'comment' => $comment,
            'mostHot' => $mostHot,
            'average' => $average,
            'pourcentage' => number_format($pourcentage, 1, ','),
            'vote' => $vote,
        ];
        return $this->render('user/index.html.twig', [
            'page' => 'profil',
            'user' => $this->getUser(),
            'stats' => $stats,
            'title' => 'Mes Badges',
        ]);
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/user/deals', name: 'app_user_deals')]
    public function deals(PublicationRepository $publicationRepo): Response
    {
        $deals = $publicationRepo->findByUser($this->getUser());
        $stats = [
            'publication' => $publicationRepo->countPublicationByUser($this->getUser()),
        ];
        return $this->render('user/index.html.twig', [
            'page' => 'deals',
            'deals' => $deals,
            'stats' => $stats,
            'title' => 'Mes deals',
        ]);
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/user/setting', name: 'app_user_setting')]
    public function setting(Request $request, PublicationRepository $publicationRepo, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfilType::class, $user);
        $user = $user->setPseudo($form->get('pseudo')->getData());
        $entityManager->persist($user);
        $entityManager->flush();
        $user = $user->setEmail($form->get('email')->getData());
        $entityManager->persist($user);
        $entityManager->flush();
        $stats = [
            'publication' => $publicationRepo->countPublicationByUser($this->getUser()),
        ];
        return $this->render('user/index.html.twig', [
            'page' => 'setting',
            'stats' => $stats,
            'form'=> $form->createView(),
            'user' => $this->getUser(),
            'title' => 'Paramètres',
        ]);
    }
}

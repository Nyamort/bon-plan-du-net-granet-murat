<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use App\Repository\CommentaireRepository;
use App\Repository\PublicationRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    public function __construct(private EmailVerifier $emailVerifier)
    {
    }


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
        try {
            $hots = $publicationRepo->findHotByUser($this->getUser());
            // find maximum hot
            $mostHot = 0;
            foreach ($hots as $hot) {
                if (current($hot) > $mostHot)
                    $mostHot = current($hot);
            }
        }
        catch(\Exception $e){
            $mostHot = 0;
        }
        if ($mostHot == null)
            $mostHot = 0;
            $rates = $publicationRepo->findNotationByUser($this->getUser());
            $average = 0;
            foreach ($rates as $rate) {
                $average += current($rate);
            }
            $average = $average / count($rates);

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
    #[Route('/user/favoris', name: 'app_user_favoris')]
    public function favoris(PublicationRepository $publicationRepo): Response
    {
        $deals = $this->getUser()->getFavoris();
        $deals = $deals->toArray();
        $stats = [
            'publication' => $publicationRepo->countPublicationByUser($this->getUser()),
        ];
        return $this->render('user/index.html.twig', [
            'page' => 'favoris',
            'deals' => $deals,
            'stats' => $stats,
            'title' => 'Mes deals favoris',
        ]);
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/user/setting', name: 'app_user_setting')]
    public function setting(Request $request, PublicationRepository $publicationRepo, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPseudo($form->get('pseudo')->getData());
            $user->setEmail($form->get('email')->getData());

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('max.gt03@gmail.com', 'EmailBot'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
        }
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

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/user/alert-publication', name: 'app_user_alert_publications')]
    public function alertPublication(PublicationRepository $publicationRepo): Response
    {
        $stats = [
            'publication' => $publicationRepo->countPublicationByUser($this->getUser()),
        ];
        /**
         * @var User $user
         * $user
         */
        $user = $this->getUser();
        $publications = $user->getPublicationsAlert();
        return $this->render('user/index.html.twig', [
            'page' => 'alert_publications',
            'publications' => $publications,
            'stats' => $stats,
            'title' => 'Mes publications alertées',
        ]);
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/user/alert', name: 'app_user_alert')]
    public function alert(PublicationRepository $publicationRepo): Response
    {
        $stats = [
            'publication' => $publicationRepo->countPublicationByUser($this->getUser()),
        ];
        /**
         * @var User $user
         * $user
         */
        $user = $this->getUser();
        $alertes = $user->getAlerts();
        return $this->render('user/index.html.twig', [
            'page' => 'alert',
            'alertes' => $alertes,
            'stats' => $stats,
            'title' => 'Mes alertes',
        ]);
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/user/delete', name: 'app_user_delete')]
    public function delete(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $this->container->get('security.token_storage')->setToken(null);

        $em->remove($user);
        $em->flush();

// Ceci ne fonctionne pas avec la création d'une nouvelle session !
        $this->addFlash('success', 'Votre compte utilisateur a bien été supprimé !');

        return $this->redirectToRoute('app_home');
    }
}

<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/favori')]
class FavoriController extends AbstractController
{


    public function __construct(
        private readonly EntityManagerInterface $em
    )
    {
    }

    #[Security('is_granted("ROLE_USER")')]
    #[ParamConverter('publication', options: ['mapping' => ['publication_id' => 'id']])]
    #[Route('/{publication_id}/toggle', name: 'app_favori_toggle')]
    public function toggle(Publication $publication, Request $request): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if($user->getFavoris()->contains($publication))
            $user->removeFavori($publication);
        else
            $user->addFavori($publication);
        $this->em->flush();

        $route = $request->headers->get('referer');

        if ($route === null) {
            return $this->redirectToRoute('app_home');
        }
        return $this->redirect($route);
    }
}

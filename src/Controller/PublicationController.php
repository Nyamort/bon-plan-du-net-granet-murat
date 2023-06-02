<?php

namespace App\Controller;

use App\Entity\Notation;
use App\Entity\Publication;
use App\Entity\User;
use App\Repository\NotationRepository;
use App\Repository\PublicationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{


    public function __construct(
        private readonly PublicationRepository $publicationRepository,
        private readonly NotationRepository $notationRepository
    )
    {
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/publication/{id}/{type}', name: 'publication_like')]
    public function like(Request $request, int $id, string $type){
        $publication = $this->publicationRepository->find($id);
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $liked = $this->notationRepository->liked($publication, $user);

        $value = match ($type) {
            'like' => 1,
            'dislike' => -1,
            default => 0,
        };
        if($value === 0){
            return $this->redirectToRoute('app_home');
        }

        if (!!$liked){
            $this->notationRepository->remove($liked, true);
        }else{
            $notation = new Notation();
            $notation->setPublication($publication);
            $notation->setUser($user);
            $notation->setValue($value);
            $this->notationRepository->save($notation, true);
        }

        $route = $request->headers->get('referer');

        if ($route === null) {
            return $this->redirectToRoute('app_home');
        }else{
            return $this->redirect($route);
        }
    }
}

<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Notation;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\CommentaireRepository;
use App\Repository\NotationRepository;
use App\Repository\PublicationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{


    public function __construct(
        private readonly PublicationRepository $publicationRepository,
        private readonly NotationRepository    $notationRepository,
        private readonly CommentaireRepository $commentaireRepository
    )
    {
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/publication/{id}/comment', name: 'app_publication_comment')]
    public function comment(Request $request, int $id): Response
    {
        $publication = $this->publicationRepository->find($id);
        $comment = new Commentaire();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $route = $request->headers->get('referer');

        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var User $user
             */
            $user = $this->getUser();
            $comment->setPublication($publication);
            $comment->setUser($user);
            $this->commentaireRepository->save($comment, true);

            if ($route === null) {
                return $this->redirectToRoute('app_home');
            } else {
                if($publication->getCodePromo() !== null)
                    return $this->redirectToRoute('app_code_promo_show', ['id' => $publication->getCodePromo()->getId()]);
                else
                    return $this->redirectToRoute('app_bon_plan_show', ['id' => $publication->getDeal()->getId()]);
            }
        }
        return $this->render('commentaire/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/publication/{id}/{type}', name: 'app_publication_like')]
    public function like(Request $request, int $id, string $type)
    {
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
        if ($value === 0) {
            return $this->redirectToRoute('app_home');
        }

        if (!!$liked) {
            $this->notationRepository->remove($liked, true);
        } else {
            $notation = new Notation();
            $notation->setPublication($publication);
            $notation->setUser($user);
            $notation->setValue($value);
            $this->notationRepository->save($notation, true);
        }

        $route = $request->headers->get('referer');

        if ($route === null) {
            return $this->redirectToRoute('app_home');
        } else {
            return $this->redirect($route);
        }
    }




}

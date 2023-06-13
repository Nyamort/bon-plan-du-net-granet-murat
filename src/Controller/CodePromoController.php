<?php

namespace App\Controller;

use App\Entity\CodePromo;
use App\Entity\Commentaire;
use App\Form\CodePromoType;
use App\Form\CommentType;
use App\Repository\CodePromoRepository;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/code-promo')]
class CodePromoController extends AbstractController
{


    public function __construct(
        private FileUploader $fileUploader
    )
    {
    }

    #[Route('/', name: 'app_code_promo_index', methods: ['GET'])]
    public function index(CodePromoRepository $codePromoRepository): Response
    {
        $codePromos = $codePromoRepository->findAll();

        return $this->render('code_promo/index.html.twig', [
            'code_promos' => $codePromos,
            'page' => 'home'
        ]);
    }

    #[Route('/hot', name: 'app_code_promo_hot', methods: ['GET'])]
    public function hot(CodePromoRepository $codePromoRepository): Response
    {
        $codePromos = $codePromoRepository->findHot();

        return $this->render('code_promo/index.html.twig', [
            'code_promos' => $codePromos,
            'page' => 'hot'
        ]);
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/new', name: 'app_code_promo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CodePromoRepository $codePromoRepository): Response
    {
        $codePromo = new CodePromo();
        $form = $this->createForm(CodePromoType::class, $codePromo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('publication')->get('image')->getData();
            if ($image) {
                $imageFileName = $this->fileUploader->upload($image);
                $codePromo->getPublication()->setImage($imageFileName);
            }
            $codePromo->getPublication()->setAuthor($this->getUser());

            $codePromoRepository->save($codePromo, true);

            return $this->redirectToRoute('app_code_promo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('code_promo/new.html.twig', [
            'code_promo' => $codePromo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_code_promo_show', methods: ['GET'])]
    public function show(CodePromo $codePromo): Response
    {
        return $this->render('code_promo/show.html.twig', [
            'code_promo' => $codePromo
        ]);
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/{id}/edit', name: 'app_code_promo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CodePromo $codePromo, CodePromoRepository $codePromoRepository): Response
    {
        $form = $this->createForm(CodePromoType::class, $codePromo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $codePromoRepository->save($codePromo, true);

            return $this->redirectToRoute('app_code_promo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('code_promo/edit.html.twig', [
            'code_promo' => $codePromo,
            'form' => $form,
        ]);
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/{id}', name: 'app_code_promo_delete', methods: ['POST'])]
    public function delete(Request $request, CodePromo $codePromo, CodePromoRepository $codePromoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$codePromo->getId(), $request->request->get('_token'))) {
            $codePromoRepository->remove($codePromo, true);
        }

        return $this->redirectToRoute('app_code_promo_index', [], Response::HTTP_SEE_OTHER);
    }
}

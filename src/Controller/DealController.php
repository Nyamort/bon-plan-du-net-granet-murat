<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Form\DealType;
use App\Repository\DealRepository;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/deal')]
class DealController extends AbstractController
{
    public function __construct(
        private FileUploader $fileUploader
    )
    {
    }

    #[Route('/', name: 'app_deal_index', methods: ['GET'])]
    public function index(DealRepository $dealRepository): Response
    {
        return $this->render('deal/index.html.twig', [
            'deals' => $dealRepository->findAll(),
        ]);
    }

    #[Route('/hot', name: 'app_deal_hot', methods: ['GET'])]
    public function hot(DealRepository $dealRepository): Response
    {
        return $this->render('deal/index.html.twig', [
            'deals' => $dealRepository->findHot(),
        ]);
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/new', name: 'app_deal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DealRepository $dealRepository): Response
    {
        $deal = new Deal();
        $form = $this->createForm(DealType::class, $deal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('publication')->get('image')->getData();
            if ($image) {
                $imageFileName = $this->fileUploader->upload($image);
                $deal->getPublication()->setImage($imageFileName);
            }
            $deal->getPublication()->setAuthor($this->getUser());
            $dealRepository->save($deal, true);

            return $this->redirectToRoute('app_deal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('deal/new.html.twig', [
            'deal' => $deal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_deal_show', methods: ['GET'])]
    public function show(Deal $deal): Response
    {
        return $this->render('deal/show.html.twig', [
            'deal' => $deal,
        ]);
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/{id}/edit', name: 'app_deal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Deal $deal, DealRepository $dealRepository): Response
    {
        $form = $this->createForm(DealType::class, $deal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dealRepository->save($deal, true);

            return $this->redirectToRoute('app_deal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('deal/edit.html.twig', [
            'deal' => $deal,
            'form' => $form,
        ]);
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/{id}', name: 'app_deal_delete', methods: ['POST'])]
    public function delete(Request $request, Deal $deal, DealRepository $dealRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deal->getId(), $request->request->get('_token'))) {
            $dealRepository->remove($deal, true);
        }

        return $this->redirectToRoute('app_deal_index', [], Response::HTTP_SEE_OTHER);
    }
}

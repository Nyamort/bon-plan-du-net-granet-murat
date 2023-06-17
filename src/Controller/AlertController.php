<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Form\AlertType;
use App\Repository\AlertRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/alert')]
class AlertController extends AbstractController
{
    #[Security('is_granted("ROLE_USER")')]
    #[Route('/new', name: 'app_alert_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AlertRepository $alertRepository): Response
    {
        $alert = new Alert();
        $form = $this->createForm(AlertType::class, $alert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $alert->setUser($this->getUser());
            $alertRepository->save($alert, true);

            return $this->redirectToRoute('app_user_alert');
        }

        return $this->renderForm('alert/new.html.twig', [
            'alert' => $alert,
            'form' => $form,
        ]);
    }

    #[Security('is_granted("ROLE_USER")')]
    #[Route('/{id}', name: 'app_alert_delete', methods: ['POST'])]
    public function delete(Request $request, Alert $alert, AlertRepository $alertRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alert->getId(), $request->request->get('_token'))) {
            $alertRepository->remove($alert, true);
        }


        $route = $request->headers->get('referer');

        if ($route === null) {
            return $this->redirectToRoute('app_home');
        }
        return $this->redirect($route);
    }
}

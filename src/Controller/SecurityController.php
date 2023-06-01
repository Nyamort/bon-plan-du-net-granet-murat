<?php

namespace App\Controller;

use PHPStan\PhpDocParser\Ast\PhpDoc\SelfOutTagValueNode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
     #[Route("/login", name:"app_login")]
    public function login(AuthenticationUtils $authenticationUtils, Session $session): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_code_promo_index');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $return = ['last_username' => $lastUsername, 'error' => $error];

        if($session->has('message'))
        {
            $message = $session->get('message');
            $session->remove('message'); //on vide la variable message dans la session
            $return['message'] = $message; //on ajoute à l'array de paramètres notre message
        }

        return $this->render('security/login.html.twig', $return);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        header('Location: /login');
    }
}

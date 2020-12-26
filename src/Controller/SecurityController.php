<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function registration () {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
 
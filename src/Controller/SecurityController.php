<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Form\RegistrationType;
use App\Form\RegistrationClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Provider\DaoAuthenticationProvider;


class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function firstPage() {
        return $this->render('security/index.html.twig');

    }
    /**
     * @Route("/inscription", name="app_register")
     */
    public function registration (Request $request,  EntityManagerInterface $manager,
    UserPasswordEncoderInterface $encoder) {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $encodePassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodePassword);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/client/inscription", name="client_register")
     */
    public function clientRegistration(Request $request, EntityManagerInterface $manager, 
    UserPasswordEncoderInterface $encoder) {
        $client = new Client();

        $form = $this->createForm(RegistrationClientType::class, $client);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $encodePassword = $encoder->encodePassword($client, $client->getPassword());
            $client->setPassword($encodePassword);
            $manager->persist($client);
            $manager->flush();

            return $this->redirectToRoute('client_login');
        }

        return $this->render('security/client_register.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/connexion", name="app_login")
     */
    public function login(){
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/client/connexion", name="client_login")
     */
    public function clientLogin(){
        return $this->render('security/client_login.html.twig');
    }

    /**
     * @Route("/deconnexion", name="app_logout")
     */
    public function logout(){
    }
}
 
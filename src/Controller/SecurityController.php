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
     * @Route("/register", name="app_register")
     */
    public function register (Request $request, EntityManagerInterface $manager,
    UserPasswordEncoderInterface $encoder) {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encodePassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodePassword);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/register.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login () {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout () {

    }

    /**
     * @Route("/client/register", name="app_client_register")
     */
    public function registerClient () {
        $client = new Client();
        $form = $this->createForm(RegistrationClientType::class, $client);
        return $this->render('security/client/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/client/login", name="app_client_login")
     */
    public function loginClient () {
        $client = new Client();
        $form = $this->createForm(RegistrationClientType::class, $client);
        return $this->render('security/client/login.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
   
}
 
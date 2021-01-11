<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\RegistrationType;
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
     * @Route("/client/register", name="app_client_register")
     */
    public function registerClient () {
        $client = new Client();
        $form = $this->createForm(RegistrationType::class, $client);
        return $this->render('security/register.html.twig', [
            $form => $form->createView()
        ]);
    }

    /**
     * @Route("/client/register", name="app_client_login")
     */
    public function loginClient () {
        $client = new Client();
        $form = $this->createForm(RegistrationType::class, $client);
        return $this->render('security/register.html.twig', [
            $form => $form->createView()
        ]);
    }
    
    // /**
    //  * @Route("/inscription", name="app_register")
    //  */
    // public function registration (Request $request,  EntityManagerInterface $manager,
    // UserPasswordEncoderInterface $encoder) {
    //     $user = new User();
    //     $form = $this->createForm(RegistrationType::class, $user);

    //     $form->handleRequest($request);
    //     if($form->isSubmitted() && $form->isValid()) {
    //         $encodePassword = $encoder->encodePassword($user, $user->getPassword());
    //         $user->setPassword($encodePassword);
    //         $manager->persist($user);
    //         $manager->flush();

    //         return $this->redirectToRoute('app_login');
    //     }
    //     return $this->render('security/register.html.twig', [
    //         'form' => $form->createView()
    //     ]);
    // }

    // /**
    //  * @Route("/connexion", name="app_login")
    //  */
    // public function login(){
    //     return $this->render('security/login.html.twig');
    // }

    // /**
    //  * @Route("/deconnexion", name="app_logout")
    //  */
    // public function logout(){
    // }
}
 
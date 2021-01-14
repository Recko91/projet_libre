<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/parametres", name="user_parameters")
     */
    public function parameters()
    {
        return $this->render('user/parameters.html.twig');
    }

    /**
     * @Route("/reservation/{id}", name="reservation")
     */
    public function reservation()
    {
        return $this->render('user/reservation.html.twig');
    }
}

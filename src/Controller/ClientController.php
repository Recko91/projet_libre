<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    /**
     * @Route("/client/parametres", name="client_parameters")
     */
    public function parameters()
    {
        return $this->render('client/parameters.html.twig');
    }
}
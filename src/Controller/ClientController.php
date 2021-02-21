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

    /**
     * @Route("/client/adresse", name="client_address")
     */
    public function address()
    {
        return $this->render('client/address/address.html.twig');
    }

    /**
     * @Route("/client/adresse/ajouter", name="add_address")
     */
    public function addAddress()
    {
        return $this->render('client/address/addAddress.html.twig');
    }

    /**
     * @Route("/client/adresse/modifier", name="mod_address")
     */
    public function modAddress()
    {
        return $this->render('client/address/modAddress.html.twig');
    }
}
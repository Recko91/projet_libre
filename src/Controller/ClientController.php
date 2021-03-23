<?php

namespace App\Controller;


use App\Entity\ClientAddress;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Address;

class ClientController extends AbstractController
{

    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

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
        $clientId = $this->security->getUser()->getId();
        $addresses= $this->getDoctrine()->getRepository(ClientAddress::class)->findByClientId($clientId);

        return $this->render('client/address/address.html.twig', [
            "addresses" => $addresses,
        ]);

    }

    /**
     * @Route("/client/adresse/ajouter", name="add_address")
     */
    public function addAddress(Request $request, EntityManagerInterface $manager)
    {
        $address = new ClientAddress();

        $form = $this->createFormBuilder($address)

                ->add('streetName', TextType::class, [
                    'attr' => [
                        'placeholder' => "Adresse",
                        'class' => 'form-control'
                    ]
                ])
                ->add('postalCode', TextType::class, [
                    'attr' => [
                        'placeholder' => "Code Postal",
                        'class' => 'form-control'
                    ]
                ])
                ->add('country', TextType::class, [
                    'attr' => [
                        'placeholder' => "Pays",
                        'class' => 'form-control'

                    ]
                ])
                ->add('capacity', TextType::class, [
                    'attr' => [
                        'placeholder' => "Capacité",
                        'class' => 'form-control'

                    ]
                ])
                ->add('price', TextType::class, [
                    'attr' => [
                        'placeholder' => "Prix",
                        'class' => 'form-control'

                    ]
                ])
                ->add('isOpen')
                ->add('save', SubmitType::class, [
                    'label' => 'Ajouter',
                    'attr' => [
                        'class' => "btn btn-primary"
                    ]
                ])
                ->getForm();

                $form->handleRequest($request);
                
                if($form->isSubmitted() && $form->isValid()) {

                    $clientId = $this->security->getUser()->getId();
                    $address->setClientId($clientId);

                    $capacity = $address->getCapacity();
                    $address->setAvailability($capacity);
                    
                    $manager->persist($address);
                    $manager->flush();

                    return $this->redirectToRoute('client_address');
                }


        return $this->render('client/address/addAddress.html.twig', [
            'formAddress' => $form->createView()
        ]);

    }

    /**
     * @Route("/client/adresse/modifier", name="mod_address")
     */
    public function modAddress()
    {
        return $this->render('client/address/modAddress.html.twig');
    }
}
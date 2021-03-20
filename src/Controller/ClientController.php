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
        return $this->render('client/address/address.html.twig');
    }

    /**
     * @Route("/client/adresse/ajouter", name="add_address")
     */
    public function addAddress(Request $request, EntityManagerInterface $manager)
    {
        $address = new ClientAddress();

        $userId = $this->security->getUser()->getId();
        $businessName = $this->security->getUser()->getBusinessName();

        

        $form = $this->createFormBuilder($address)

                ->add('availability', HiddenType::class, [
                    'attr' => [
                        'value' => "5",
                    ]
                ])
                ->add('streetNumber', TextType::class, [
                    'attr' => [
                        'placeholder' => "Numéro de rue",
                        'class' => 'form-control'
                    ]
                ])
                ->add('streetName', TextType::class, [
                    'attr' => [
                        'placeholder' => "Nom de rue",
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
                dump($address);

                $address->setClientId($userId);

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
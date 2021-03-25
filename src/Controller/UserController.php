<?php

namespace App\Controller;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Comment;

class UserController extends AbstractController
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
     * @Route("/parametres", name="user_parameters")
     */
    public function parameters()
    {
        return $this->render('user/parameters.html.twig');
    }

    /**
     * @Route("/mes-reservations", name="booked")
     */
    public function booked()
    {
        return $this->render('user/booked.html.twig');
    }

    /**
     * @Route("/reservation/{id}", name="reservation")
     */
    public function reservation(Request $request, EntityManagerInterface $manager, $id)
    {
        $reservation = new Reservation();

        $form = $this->createFormBuilder($reservation)

            ->add('vehicleQuantity', IntegerType::Class, [
                'attr' => [
                    'placeholder' => 'Combien de Vehicule ?',
                    'class' => 'form-control'
                ]
            ])
            ->add('startDate', DateTimeType::Class, [
                'attr' => [
                    'placeholder' => 'À partir de',
                    'class' => 'form-control'
                ]
            ])
            ->add('endDate', DateTimeType::Class, [
                'attr' => [
                    'placeholder' => 'Jusqu à',
                    'class' => 'form-control'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Je réserve',
                'attr' => [
                    'class' => "btn btn-primary btn-block btn-reservation"
                ]
            ])
            ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $userId = $this->security->getUser()->getId();
                $reservation->setUserId($userId);
                $reservation->setAddressId(intval($id));

                $manager->persist($reservation);
                $manager->flush();

                return $this->redirectToRoute('booked');
            }
            $repo = $this->getDoctrine()->getRepository(Comment::class);
             $lists = $repo->findAll();

            return $this->render('user/reservation.html.twig', [
                'lists'=>$lists,
                'formReservation' =>$form->createView()
            ]);
    }
}

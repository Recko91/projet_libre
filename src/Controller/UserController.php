<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Reservation;
use App\Entity\ClientAddress;
use App\Form\RegistrationType;
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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function parameters(Request $request, UserPasswordEncoderInterface $encoder)
    {
        
        $user = $this->getUser();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $encodePassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodePassword);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_index');
        }
        return $this->render('user/parameters.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/mes-reservations", name="booked")
     */
    public function booked()
    {
        $userId = $this->security->getUser()->getId();
        $reservations = $this->getDoctrine()->getRepository(Reservation::class)->findByUserId($userId);
        dump($reservations);
        return $this->render('user/booked.html.twig', [
            "reservations" => $reservations]);
    }

    /**
     * @Route("/mes-reservations/supprimer/{id}", name="suppr_booked")
     */
    public function deleteBooked(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reservation = $entityManager->getRepository(Reservation::class)->find($id);

        $entityManager->remove($reservation);
        $entityManager->flush();

        return $this->redirectToRoute('booked');
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
            $comments = $this->getDoctrine()->getRepository(Comment::class)->findByAddressId($id);
            return $this->render('user/reservation.html.twig', [
                'comments'=>$comments,
                'formReservation' =>$form->createView()
            ]);
    }

    /**
     * @Route("/toutes-les-adresses", name="every_addresses")
     */
    public function allAddress()
    {
        $addresses = $this->getDoctrine()->getRepository(ClientAddress::class)->findAll();
        dump($addresses);

        return $this->render('user/all_addresses.html.twig', [
            "addresses" => $addresses]);
    }
}

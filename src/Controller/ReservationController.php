<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Speciality;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use App\Repository\SpecialityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(UserRepository $userRepository,ReservationRepository $reservationRepository): Response
    {
        $userp = $this->getUser()->getId();
        return $this->render('reservation/display.html.twig', [

            'reservations' => $reservationRepository->ghayth($userp),
           
        ]);
    }


    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index_med(UserRepository $userRepository,ReservationRepository $reservationRepository): Response
    {
        $userp = $this->getUser()->getId();
        return $this->render('reservation/display.html.twig', [

            'reservations' => $reservationRepository->ghayth_med($userp),
           
        ]);
    }

    

    
    #[Route('/s', name: 'app_reservation_specialite', methods: ['GET', 'POST'])]
    public function specialite(SpecialityRepository $specialiteRepository): Response
    {

        return $this->render('reservation/specialité.html.twig', [

            'specialite' => $specialiteRepository->findAll(),
           
        ]);
    }

   


    #[Route('/{id}/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservationRepository $reservationRepository, UserRepository $userRepository ,$id): Response
    {    

        
        $users = $userRepository->findmed($id);
        $userp = $this->getUser();
        $reservation = new Reservation();
       
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setUsers($users); 
            $reservation->setPatient($userp);
            $reservationRepository->save($reservation, true);
           
            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/add.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
            'users' => $users,
        ]);
    }


    #[Route('/{id}/ed', name: 'app_reservation_med', methods: ['GET'])]
    public function medbyspe(Speciality $specialite ): Response
    {      
        
        return $this->render('reservation/med.html.twig', [
  'all' => $specialite,
            'med' => $specialite->getMedecin(),
           
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation , UserRepository $userRepository): Response
    {
              $khouna= $reservation->getUsers();


        return $this->render('reservation/show1.html.twig', [
            'reservation' => $reservation,
             'users' => $userRepository->find($khouna) ,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit1.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $reservationRepository->remove($reservation, true);
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}

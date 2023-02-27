<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FileType;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('back_office/evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }
    #[Route('/events', name: 'app_evenement_index_front', methods: ['GET'])]
    public function frontindex(EvenementRepository $evenementRepository): Response
    {
        return $this->render('/events/list.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }
    #[Route('/details', name: 'app_evenement_index_front_details', methods: ['GET'])]
    public function frontindexx(EvenementRepository $evenementRepository): Response
    {
        return $this->render('main/details.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EvenementRepository $evenementRepository): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenementRepository->save($evenement, true);

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_office/evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        
        return $this->render('back_office/evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }
    #[Route('/user/{id}', name: 'app_evenement_show_front', methods: ['GET'])]
    public function showf(Evenement $evenement): Response
    {
        
        return $this->render('events/eventDetails.html.twig', [
            'evenement' => $evenement,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            
            $evenementRepository->save($evenement, true);

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back_office/evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_evenement_delete', methods: ['GET'])]
    public function delete(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
         
            $evenementRepository->remove($evenement, true);
        

        return $this->render('back_office/evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
        
}


}
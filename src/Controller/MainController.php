<?php

namespace App\Controller;

use App\Entity\UpdateTicket;
use App\Form\CreateTicketFormType;
use App\Form\Handler\CreateTicketFormHandler;
use App\Repository\HeroesRepository;
use App\Repository\RolesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function homepage(HeroesRepository $heroesRepository, RolesRepository $rolesRepository): Response
    {

        return $this->render('main/index.html.twig', [

            'heroes' => $heroesRepository->findBy(
                [],
                ['name' => 'asc']
            ),

        ]);
    }
    #[Route('/create/ticket', name: 'app_create_ticket')]
    public function createUpdateTicket(CreateTicketFormHandler $createTicketFormHandler, Security $security, Request $request, EntityManagerInterface $entityManager): Response
    {
        $updateTicket = new UpdateTicket;
        $form = $this->createForm(CreateTicketFormType::class, $updateTicket);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $createTicketFormHandler->handle($updateTicket, $entityManager, $security);
            return $this->redirectToRoute('app_home');
        }
        return $this->render('main/create_ticket.html.twig', ['ticketForm' => $form->createView()]);
    }
}

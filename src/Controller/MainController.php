<?php

namespace App\Controller;

use App\Entity\UpdateTicket;
use App\Form\CreateTicketFormType;
use App\Repository\HeroesRepository;
use App\Repository\RolesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function homepage(HeroesRepository $heroesRepository, RolesRepository $rolesRepository): Response
    {
        $this->getUser()->getRoles();
        return $this->render('main/index.html.twig', [

            'heroes' => $heroesRepository->findBy(
                [],
                ['name' => 'asc']
            ),

        ]);
    }
    #[Route('/create/ticket', name: 'app_create_ticket')]
    public function createUpdateTicket(Request $request, EntityManagerInterface $entityManager): Response
    {
        $updateTicket = new UpdateTicket;
        $form = $this->createForm(CreateTicketFormType::class, $updateTicket);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $date = new \DateTimeImmutable('@' . strtotime('now'));
            $updateTicket->setDate($date);
            $updateTicket->setAuthor($this->getUser());
            $entityManager->persist($updateTicket);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('main/create_ticket.html.twig', ['ticketForm' => $form->createView()]);
    }
}

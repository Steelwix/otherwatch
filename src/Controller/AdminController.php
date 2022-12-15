<?php

namespace App\Controller;

use App\Repository\HeroesRepository;
use App\Repository\UpdateTicketRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }

    #[Route('/ticket', name: 'app_admin_ticket')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function manageTickets(UpdateTicketRepository $updateTicketRepository): Response
    {
        $tickets = $updateTicketRepository->findAll();
        return $this->render('admin/ticket.html.twig', ['tickets' => $tickets]);
    }
    #[Route('/heroes', name: 'app_admin_heroe')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function manageHeroes(HeroesRepository $heroesRepository): Response
    {
        $heroes = $heroesRepository->findBy(
            [],
            ['name' => 'asc']
        );
        return $this->render('admin/heroes.html.twig', ['heroes' => $heroes]);
    }
}

<?php

namespace App\Controller;

use App\Repository\UpdateTicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/ticket', name: 'app_admin_ticket')]
    public function adminTicker(UpdateTicketRepository $updateTicketRepository): Response
    {
        $tickets = $updateTicketRepository->findAll();
        return $this->render('admin/ticket.html.twig', ['tickets' => $tickets]);
    }
}

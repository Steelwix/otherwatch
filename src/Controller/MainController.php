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
    private $createTicketFormHandler;
    private $heroesRepository;
    private $security;
    private $request;
    private $entityManager;

    public function __construct(
        CreateTicketFormHandler $createTicketFormHandler,
        HeroesRepository $heroesRepository,
        Security $security,
        Request $request,
        EntityManagerInterface $entityManager
    ) {
        $this->createTicketFormHandler = $createTicketFormHandler;
        $this->heroesRepository = $heroesRepository;
        $this->security = $security;
        $this->request = $request;
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'app_home')]
    public function homepage(): Response
    {
        return $this->render('main/index.html.twig', [

            'heroes' => $this->heroesRepository->findBy(
                [],
                ['name' => 'asc']
            ),

        ]);
    }
    #[Route('/create/ticket', name: 'app_create_ticket')]
    public function createUpdateTicket(): Response
    {
        $updateTicket = new UpdateTicket;
        $form = $this->createForm(CreateTicketFormType::class, $updateTicket);
        $form->handleRequest($this->request);
        if ($form->isSubmitted() and $form->isValid()) {
            $this->createTicketFormHandler->handle($updateTicket, $this->entityManager, $this->security);
            return $this->redirectToRoute('app_home');
        }
        return $this->render('main/create_ticket.html.twig', ['ticketForm' => $form->createView()]);
    }
}

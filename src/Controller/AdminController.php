<?php

namespace App\Controller;

use App\Entity\Heroes;
use App\Entity\Messages;
use App\Entity\UpdateTicket;
use App\Repository\HeroesRepository;
use App\Repository\MessagesRepository;
use App\Repository\UpdateTicketRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/blackwatch', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }

    #[Route('/blackwatch/tickets', name: 'app_admin_ticket')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function manageTickets(UpdateTicketRepository $updateTicketRepository): Response
    {
        $tickets = $updateTicketRepository->findAll();
        return $this->render('admin/ticket.html.twig', ['tickets' => $tickets]);
    }
    #[Route('/blackwatch/heroes', name: 'app_admin_heroe')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function manageHeroes(HeroesRepository $heroesRepository): Response
    {
        $heroes = $heroesRepository->findBy(
            [],
            ['name' => 'asc']
        );
        return $this->render('admin/heroes.html.twig', ['heroes' => $heroes]);
    }
    #[Route('/blackwatch/users', name: 'app_admin_user')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function manageUsers(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findBy(
            [],
            ['username' => 'asc']
        );
        return $this->render('admin/users.html.twig', ['users' => $users]);
    }
    #[Route('/blackwatch/comments', name: 'app_admin_comment')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function manageComments(MessagesRepository $messagesRepository): Response
    {
        $comments = $messagesRepository->findBy(
            []
        );

        return $this->render('admin/messages.html.twig', ['comments' => $comments]);
    }
    #[Route('/blackwatch/comments/delete/{id}', name: 'app_delete_comment')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function deleteComment(Messages $messages, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($messages);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_comment');
    }
    #[Route('/blackwatch/abilities/{id}', name: 'app_ability_heroe')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function manageAbility(Heroes $heroes): Response
    {
        $abilities = $heroes->getAbilities();
        return $this->render('admin/heroe_abilities.html.twig', ['heroes' => $heroes, 'abilities' => $abilities]);
    }
    #[Route('/blackwatch/tickets/delete/{id}', name: 'app_delete_ticket')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function confirmTicket(UpdateTicket $ticket, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($ticket);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_ticket');
    }
}

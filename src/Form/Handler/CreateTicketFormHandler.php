<?php

namespace App\Form\Handler;

use App\Entity\Heroes;
use App\Entity\UpdateTicket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security;

class CreateTicketFormHandler
{
    public function handle($updateTicket, $entityManager, $security)
    {
        $date = new \DateTimeImmutable('@' . strtotime('now'));
        $updateTicket->setDate($date);
        $updateTicket->setAuthor($security->getUser());
        $entityManager->persist($updateTicket);
        $entityManager->flush();
    }
}

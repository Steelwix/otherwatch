<?php

namespace App\Form\Handler;

use App\Entity\Heroes;
use App\Entity\Messages;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security;

class NewMessageOnHeroePostFormHandler
{
    public function handle(FormInterface $form, Messages $newMessage, Heroes $heroes, EntityManagerInterface $entityManager, Security $security)
    {
        $date = new \DateTimeImmutable('@' . strtotime('now'));
        $newMessage->setDate($date);
        $newMessage->setHeroes($heroes);
        $newMessage->setUsers($security->getUser());
        $newMessage->setContent($form->get('content')->getData());
        $entityManager->persist($newMessage);
        $entityManager->flush();
    }
}

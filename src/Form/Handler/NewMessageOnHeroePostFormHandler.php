<?php

namespace App\Form\Handler;

use App\Entity\Heroes;
use App\Entity\Messages;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security;

class NewMessageOnHeroePostFormHandler
{
    public function handle($form, $newMessage, $heroes, $entityManager, $security)
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

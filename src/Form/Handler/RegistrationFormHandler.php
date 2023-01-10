<?php

namespace App\Form\Handler;

use App\Entity\Abilities;
use App\Entity\Heroes;
use App\Entity\UpdateTicket;
use App\Service\MediasManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security;

class RegistrationFormHandler
{
    public function handle($mediasManager, $entityManager, $form, $users, $passwordHasher)
    {
        if ($form->get('profilePicture')->getData() != null) {
            $mediasManager->newProfilePicture($form->get('profilePicture')->getData(), $users);
        }

        $hashedPassword = $passwordHasher->hashPassword(
            $users,
            $form->get('password')->getData()
        );
        $users->setPassword($hashedPassword);
        $entityManager->persist($users);
        $entityManager->flush();
    }
}

<?php

namespace App\Form\Handler;

use App\Entity\Abilities;
use App\Entity\Heroes;
use App\Entity\UpdateTicket;
use App\Service\MediasManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security;

class AbilityFormHandler
{
    public function handle($mediasManager, $entityManager, $form, $ability)
    {
        $spellsIcons = $form->get('spellsIcons')->getData();
        if ($spellsIcons != null) {
            $mediasManager->newSpellIcon($form->get('spellsIcons')->getData(), $ability);
        }
        $entityManager->persist($ability);
        $entityManager->flush();
    }
}

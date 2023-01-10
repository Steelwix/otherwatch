<?php

namespace App\Form\Handler;

use App\Entity\Abilities;
use App\Entity\Heroes;
use App\Entity\UpdateTicket;
use App\Service\MediasManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\UnicodeString;

class HeroeFormHandler
{
    public function handle($mediasManager, $entityManager, $form, $heroes, $illustrationsRepository)
    {
        if ($form->get('medias')->getData() != null) {
            $oldIllustration = $illustrationsRepository->findByHeroes($heroes);
            $entityManager->remove($oldIllustration);
            $mediasManager->newIllustration($form->get('medias')->getData(), $heroes);
        }
        if ($form->get('heroeBackground')->getData() != null) {
            $mediasManager->newBackground($form->get('heroeBackground')->getData(), $heroes);
        }

        $date = new \DateTime('@' . strtotime('now'));
        $heroes->setModificationDate($date);
        $heroesName = $form->get('name')->getData();
        $heroesNameNoSpace = $heroesName ? new UnicodeString(str_replace(' ', '-', $heroesName)) : null;
        $heroesSlug = strtolower($heroesNameNoSpace);
        $heroes->setSlug($heroesSlug);
        $entityManager->persist($heroes);
        $entityManager->flush();
    }
}

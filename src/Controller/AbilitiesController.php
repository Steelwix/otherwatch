<?php

namespace App\Controller;

use App\Entity\Abilities;
use App\Entity\SpellsIcons;
use App\Form\CreateAbilityFormType;
use App\Repository\AbilitiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbilitiesController extends AbstractController
{
    #[Route('/create/ability', name: 'app_new_ability')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function createAbility(AbilitiesRepository $abilitiesRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $abilities = new Abilities;
        $form = $this->createForm(CreateAbilityFormType::class, $abilities);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $spellsIcons = $form->get('spellsIcons')->getData();
            $spellsName = md5(uniqid()) . '.' . $spellsIcons->guessExtension();
            $spellsIcons->move(
                $this->getParameter('spells_icons_directory'),
                $spellsName
            );
            $newSpellsIcons = new SpellsIcons();
            $newSpellsIcons->setName($spellsName);
            $abilities->setSpellsIcons($newSpellsIcons);
            $entityManager->persist($abilities);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render(
            'abilities/create_abilities.html.twig',
            [
                'abilityForm' => $form->createView(), 'abilities' => $abilities
            ]
        );
    }
}

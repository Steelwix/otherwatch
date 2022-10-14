<?php

namespace App\Controller;

use App\Entity\Abilities;
use App\Form\CreateAbilityFormType;
use App\Repository\AbilitiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbilitiesController extends AbstractController
{
    #[Route('/create/ability', name: 'app_abilities')]
    public function createAbility(AbilitiesRepository $abilitiesRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $abilities = new Abilities;
        $form = $this->createForm(CreateAbilityFormType::class, $abilities);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
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

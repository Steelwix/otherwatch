<?php

namespace App\Controller;

use App\Entity\Heroes;
use App\Form\CreateHeroeFormType;
use App\Repository\HeroesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HeroesController extends AbstractController
{
    #[Route('/create/heroe', name: 'app_new_heroe')]
    public function createHeroe(HeroesRepository $heroesRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $heroes = new Heroes;
        $form = $this->createForm(CreateHeroeFormType::class, $heroes);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->persist($heroes);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render(
            'heroes/create_heroes.html.twig',
            [
                'HeroeForm' => $form->createView(), 'heroes' => $heroes
            ]
        );
    }
    #[Route('/{slug}', name: 'app_guide')]
    public function guidePage(Heroes $heroes, HeroesRepository $heroesRepository): Response
    {

        return $this->render('heroes/heroepage.html.twig', ['heroes' => $heroes]);
    }
}

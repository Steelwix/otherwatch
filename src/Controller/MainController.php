<?php

namespace App\Controller;

use App\Entity\Heroes;
use App\Repository\HeroesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function homepage(HeroesRepository $heroesRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'heroes' => $heroesRepository->findBy(
                [],
                ['name' => 'asc']
            )
        ]);
    }
    #[Route('/{slug}', name: 'app_guide')]
    public function guidePage(Heroes $heroes, HeroesRepository $heroesRepository): Response
    {

        return $this->render('main/heroepage.html.twig');
    }
}

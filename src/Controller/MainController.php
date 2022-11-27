<?php

namespace App\Controller;

use App\Entity\Heroes;
use App\Service\MessageGenerator;
use App\Repository\HeroesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
}

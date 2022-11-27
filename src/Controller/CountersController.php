<?php

namespace App\Controller;

use App\Entity\Counters;
use App\Form\MakeCounterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountersController extends AbstractController
{
    #[Route('/create/counter', name: 'app_create_counter')]
    public function createCounter(EntityManagerInterface $entityManager,  Request $request): Response
    {
        $counters = new Counters();
        $form = $this->createForm(MakeCounterFormType::class, $counters);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->persist($counters);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('counters/create_counter.html.twig', [
            'CounterForm' => $form->createView(), 'counters' => $counters
        ]);
    }
}

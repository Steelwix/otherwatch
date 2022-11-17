<?php

namespace App\Controller;

use App\Entity\Heroes;
use App\Entity\Illustrations;
use App\Entity\Medias;
use App\Entity\Messages;
use App\Form\CommentaryFormType;
use App\Form\CreateHeroeFormType;
use App\Repository\HeroesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\UnicodeString;

class HeroesController extends AbstractController
{
    #[Route('/create/heroe', name: 'app_new_heroe')]
    public function createHeroe(HeroesRepository $heroesRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $heroes = new Heroes;
        $form = $this->createForm(CreateHeroeFormType::class, $heroes);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $medias = $form->get('medias')->getData();
            $mediasname = md5(uniqid()) . '.' . $medias->guessExtension();
            $medias->move(
                $this->getParameter('media_directory'),
                $mediasname
            );
            $mds = new Medias();
            $mds->setName($mediasname);
            $heroes->addMedia($mds);
            $illu = new Illustrations();
            $illu->setMedias($mds);
            $heroes->setIllustrations($illu);
            $date = new \DateTime('@' . strtotime('now'));
            $heroes->setCreationDate($date);
            $heroesName = $form->get('name')->getData();
            $heroesNameNoSpace = $heroesName ? new UnicodeString(str_replace(' ', '-', $heroesName)) : null;
            $heroesSlug = strtolower($heroesNameNoSpace);
            $heroes->setSlug($heroesSlug);

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
    #[Route('/heroe/{slug}', name: 'app_guide')]
    public function guidePage(Heroes $heroes, HeroesRepository $heroesRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        $abilities = $heroes->getAbilities();
        $messages = $heroes->getMessages();
        $newMessage = new Messages();
        $form = $this->createForm(CommentaryFormType::class, $newMessage);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $date = new \DateTimeImmutable('@' . strtotime('now'));
            $newMessage->setDate($date);
            $newMessage->setHeroes($heroes);
            $newMessage->setUsers($this->getUser());
            $newMessage->setContent($form->get('content')->getData());
            $entityManager->persist($newMessage);
            $entityManager->flush();
            $currentSlug = $heroes->getSlug();
            return $this->redirectToRoute('app_guide', ['slug' => $currentSlug]);
        }

        return $this->render('heroes/heroepage.html.twig', ['heroes' => $heroes, 'abilities' => $abilities, 'messages' => $messages, 'comForm' => $form->createView()]);
    }
}

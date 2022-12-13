<?php

namespace App\Controller;

use App\Service\MediasManager;
use App\Entity\Heroes;
use App\Entity\Illustrations;
use App\Entity\Medias;
use App\Entity\Messages;
use App\Form\CommentaryFormType;
use App\Form\CreateHeroeFormType;
use App\Form\ModifyHeroeFormType;
use App\Repository\CountersRepository;
use App\Repository\HeroesRepository;
use App\Repository\IllustrationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\UnicodeString;

class HeroesController extends AbstractController
{

    #[Route('/create/heroe', name: 'app_new_heroe')]
    public function createHeroe(HeroesRepository $heroesRepository, MediasManager $mediasManager, Request $request, EntityManagerInterface $entityManager): Response
    {
        $heroes = new Heroes;
        $form = $this->createForm(CreateHeroeFormType::class, $heroes);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $mediasManager->newIllustration($form->get('medias')->getData(), $heroes);

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
        $counters = $heroes->getCounter();
        $synergies = $heroes->getSynergy();
        $allHeroes = $heroesRepository->findAll();
        $isCountered = [];
        foreach ($allHeroes as $heroe) {
            foreach ($heroe->getSynergy() as $synergie) {
                if ($synergie == $heroes) {
                    $synergies[] = $heroe;
                }
            }
            foreach ($heroe->getCounter() as $heroeGetCounter) {
                if ($heroeGetCounter == $heroes) {
                    $isCountered[] = $heroe;
                }
            }
        }
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
        $returnValue = compact('heroes', 'abilities', 'messages', 'counters', 'isCountered', 'synergies');
        $returnValue['comForm'] =  $form->createView();
        return $this->render('heroes/heroepage.html.twig', $returnValue);
    }
    #[Route('/modify/heroe/{id}', name: 'app_modify_heroe')]
    public function modifyHeroe(Heroes $heroes, Request $request, MediasManager $mediasManager, IllustrationsRepository $illustrationsRepository, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ModifyHeroeFormType::class, $heroes);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
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
            $currentSlug = $heroes->getSlug();
            return $this->redirectToRoute('app_guide', ['slug' => $currentSlug]);
        }
        return $this->render('heroes/modify_heroes.html.twig', [
            'heroes' => $heroes,
            'HeroeForm' => $form->createView()
        ]);
    }
    #[Route('/delete/heroe/{id}', name: 'app_delete_heroe')]
    public function deleteHeroe(Heroes $heroes, Request $request, MediasManager $mediasManager, IllustrationsRepository $illustrationsRepository, EntityManagerInterface $entityManager)
    {
        $illustrations = $heroes->getIllustrations();
        $abilities = $heroes->getAbilities();
        $medias = $heroes->getMedias();
        foreach ($illustrations as $illustration) {
            $entityManager->remove($illustration);
        }
        foreach ($abilities as $ability) {
            $spellIcon = $ability->getSpellsIcons();
            $entityManager->remove($spellIcon);
            $entityManager->remove($ability);
        }
        foreach ($medias as $media) {
            $entityManager->remove($media);
        }
        $entityManager->remove($heroes);
        $entityManager->flush();
        return $this->redirectToRoute('app_home');
    }
}

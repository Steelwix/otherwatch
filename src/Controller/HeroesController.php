<?php

namespace App\Controller;

use App\Service\MediasManager;
use App\Entity\Heroes;
use App\Entity\Illustrations;
use App\Entity\Medias;
use App\Entity\Messages;
use App\Form\CommentaryFormType;
use App\Form\CreateHeroeFormType;
use App\Form\Handler\HeroeFormHandler;
use App\Form\ModifyHeroeFormType;
use App\Repository\CountersRepository;
use App\Repository\HeroesRepository;
use App\Repository\IllustrationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Handler\NewMessageOnHeroePostFormHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\UnicodeString;

class HeroesController extends AbstractController
{

    #[Route('/create/heroe', name: 'app_new_heroe')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function createHeroe(HeroeFormHandler $heroeFormHandler, IllustrationsRepository $illustrationsRepository, MediasManager $mediasManager, Request $request, EntityManagerInterface $entityManager): Response
    {
        $heroes = new Heroes;
        $form = $this->createForm(CreateHeroeFormType::class, $heroes);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $heroeFormHandler->handle($mediasManager, $entityManager, $form, $heroes, $illustrationsRepository);
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
    public function guidePage(Security $security, NewMessageOnHeroePostFormHandler $newMessageOnHeroePostFormHandler, Heroes $heroes, HeroesRepository $heroesRepository, Request $request, EntityManagerInterface $entityManager): Response
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
            $newMessageOnHeroePostFormHandler->handle($form, $newMessage, $heroes, $entityManager, $security);
            $currentSlug = $heroes->getSlug();
            return $this->redirectToRoute('app_guide', ['slug' => $currentSlug]);
        }
        $returnValue = compact('heroes', 'abilities', 'messages', 'counters', 'isCountered', 'synergies');
        $returnValue['comForm'] =  $form->createView();
        return $this->render('heroes/heroepage.html.twig', $returnValue);
    }
    #[Route('/modify/heroe/{id}', name: 'app_modify_heroe')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function modifyHeroe(HeroeFormHandler $heroeFormHandler, Heroes $heroes, Request $request, MediasManager $mediasManager, IllustrationsRepository $illustrationsRepository, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ModifyHeroeFormType::class, $heroes);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $heroeFormHandler->handle($mediasManager, $entityManager, $form, $heroes, $illustrationsRepository);
            $currentSlug = $heroes->getSlug();
            return $this->redirectToRoute('app_guide', ['slug' => $currentSlug]);
        }
        return $this->render('heroes/modify_heroes.html.twig', [
            'heroes' => $heroes,
            'HeroeForm' => $form->createView()
        ]);
    }
    #[Route('/delete/heroe/{id}', name: 'app_delete_heroe')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
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

<?php

namespace App\Controller;

use App\Entity\ProfilesPictures;
use App\Entity\Users;
use App\Form\ModifyUserFormType;
use App\Repository\ProfilesPicturesRepository;
use App\Service\MediasManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/create/user', name: 'app_create_user')]
    public function createUser(Request $request, MediasManager $mediasManager, EntityManagerInterface $entityManager): Response
    {
        $users = new Users;
        $form = $this->createForm(CreateUserFormType::class, $users);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $mediasManager->newProfilePicture($form->get('profilePictures')->getData(), $users);
            $entityManager->persist($users);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/create.html.twig', [
            'UserForm' => $form->createView(), 'users' => $users
        ]);
    }
    #[Route('/modify/user/{id}', name: 'app_modify_user')]
    public function modifyUser(Users $users, Request $request, MediasManager $mediasManager, ProfilesPicturesRepository $profilesPicturesRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ModifyUserFormType::class, $users);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            if ($form->get('profilePicture')->getData() != null) {
                //$oldPP = $profilesPicturesRepository->findByUsers($users);
                // $entityManager->remove($oldPP);
                $mediasManager->newProfilePicture($form->get('profilePicture')->getData(), $users);
                $entityManager->persist($users);
                $entityManager->flush();
                return $this->redirectToRoute('app_home');
            }
        }
        return $this->render('user/modify.html.twig', [
            'UserForm' => $form->createView(), 'users' => $users
        ]);
    }
    #[Route('/delete/user/{id}', name: 'app_delete_user')]
    public function deleteUser(Users $users): Response
    {
        return $this->render('user/delete.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\ProfilesPictures;
use App\Entity\Users;
use App\Form\CreateUserFormType;
use App\Form\Handler\RegistrationFormHandler;
use App\Form\ModifyUserFormType;
use App\Repository\ProfilesPicturesRepository;
use App\Service\MediasManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    #[Route('/modify/user/{id}', name: 'app_modify_user')]
    public function modifyUser(UserPasswordHasherInterface $passwordHasher, RegistrationFormHandler $registrationFormHandler, Users $users, Request $request, MediasManager $mediasManager, ProfilesPicturesRepository $profilesPicturesRepository, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() !== $users) {
            $this->denyAccessUnlessGranted('ISADMIN');
        }
        $form = $this->createForm(ModifyUserFormType::class, $users);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $registrationFormHandler->handle($mediasManager, $entityManager, $form, $users, $passwordHasher);
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/modify.html.twig', [
            'UserForm' => $form->createView(), 'users' => $users
        ]);
    }
    #[Route('/delete/user/{id}', name: 'app_delete_user')]
    public function deleteUser(Users $users, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() !== $users) {
            $this->denyAccessUnlessGranted('ISADMIN');
        }
        $entityManager->remove($users);
        $entityManager->flush();
        return $this->render('app_home');
    }
}

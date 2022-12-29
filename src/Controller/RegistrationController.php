<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\CreateUserFormType;
use App\Form\RegistrationFormType;
use App\Service\MediasManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/create/user', name: 'app_create_user')]
    public function createUser(UserPasswordHasherInterface $passwordHasher, Request $request, MediasManager $mediasManager, EntityManagerInterface $entityManager)
    {

        $users = new Users;
        $form = $this->createForm(CreateUserFormType::class, $users);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $mediasManager->newProfilePicture($form->get('profilePicture')->getData(), $users);
            $hashedPassword = $passwordHasher->hashPassword(
                $users,
                $form->get('password')->getData()
            );
            $users->setPassword($hashedPassword);
            $entityManager->persist($users);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/create.html.twig', [
            'UserForm' => $form->createView(), 'users' => $users
        ]);
    }
}

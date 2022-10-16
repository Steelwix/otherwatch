<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/create/user', name: 'app_create_user')]
    public function createUser(UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $entityManager)
    {

        $users = new Users;
        $form = $this->createForm(RegistrationFormType::class, $users);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $users,
                $form->get('clearPassword')->getData()
            );
            $users->setPassword($hashedPassword);
            $entityManager->persist($users);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render(
            'registration/registration.html.twig',
            [
                'registrationForm' => $form->createView(), 'users' => $users
            ]
        );
    }
}

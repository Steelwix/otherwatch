<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\CreateUserFormType;
use App\Form\Handler\RegistrationFormHandler;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Service\MediasManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class RegistrationController extends AbstractController
{
    private $verifyEmailHelper;
    private $mailer;

    public function __construct(VerifyEmailHelperInterface $helper, MailerInterface $mailer)
    {
        $this->verifyEmailHelper = $helper;
        $this->mailer = $mailer;
    }


    #[Route('/create/user', name: 'app_create_user')]
    public function createUser(RegistrationFormHandler $registrationFormHandler, UserPasswordHasherInterface $passwordHasher, Request $request, MediasManager $mediasManager, EntityManagerInterface $entityManager)
    {

        $users = new Users;
        $form = $this->createForm(CreateUserFormType::class, $users);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $registrationFormHandler->handle($mediasManager, $entityManager, $form, $users, $passwordHasher);

            $signatureComponents = $this->verifyEmailHelper->generateSignature('app_verify_user', $users->getId(), $users->getEmail(),  ['id' => $users->getId()]);
            $email = new TemplatedEmail();
            $email->from(new Address('exagond3d@gmail.com', 'Otherwatch'));
            $email->to($users->getEmail());
            $email->subject("Activez votre compte");
            $email->htmlTemplate('registration/confirmation_email.html.twig');
            $email->context(['signedUrl' => $signatureComponents->getSignedUrl(), 'username' => $users->getUsername()]);
            $this->mailer->send($email);
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/create.html.twig', [
            'UserForm' => $form->createView(), 'users' => $users
        ]);
    }
    #[Route('/verify/user', name: 'app_verify_user')]
    public function verifyUserEmail(Request $request, UsersRepository $usersRepository, EntityManagerInterface $entityManager): Response
    {
        $id = $request->get('id');

        if (null == $id) {
            return $this->redirectToRoute('app_home');
        }
        $user = $usersRepository->find($id);
        if (null == $user) {
            return $this->redirectToRoute('app_home');
        }


        // Do not get the User's Id or Email Address from the Request object
        try {

            $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());
        } catch (VerifyEmailExceptionInterface $e) {
            $this->addFlash('verify_email_error', $e->getReason());

            return $this->redirectToRoute('app_create_user');
        }

        // Mark your user as verified. e.g. switch a User::verified property to true
        $user->setIsVerified(true);
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success', 'Votre e-mail est désormais validé');

        return $this->redirectToRoute('app_home');
    }
}

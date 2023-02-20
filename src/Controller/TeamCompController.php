<?php

namespace App\Controller;

use App\Entity\TeamComps;
use App\Form\CreateTeamCompFormType;
use App\Repository\TeamCompsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamCompController extends AbstractController
{
    #[Route('/team', name: 'app_team')]
    public function teamCompView(TeamCompsRepository $teamCompsRepository): Response
    {

        return $this->render('team_comp/index.html.twig', ['teams' => $teamCompsRepository->findAll()]);
    }
    #[Route('/create/team', name: 'app_create_team')]
    public function createTeamComp(Request $request, EntityManagerInterface $entityManager): Response
    {
        $teamcomp = new TeamComps;
        $form = $this->createForm(CreateTeamCompFormType::class, $teamcomp);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->persist($teamcomp);
            $entityManager->flush();
            return $this->redirectToRoute('app_team');
        }
        return $this->render('team_comp/create.html.twig', ['teamForm' => $form->createView()]);
    }
    #[Route('/modify/comp/{id}', name: 'app_modify_comp')]
    public function modifyTeamComp(TeamComps $teamcomp, Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(CreateTeamCompFormType::class, $teamcomp);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->persist($teamcomp);
            $entityManager->flush();
            return $this->redirectToRoute('app_team');
        }
        return $this->render('team_comp/create.html.twig', ['teamForm' => $form->createView()]);
    }
    #[Route('/delete/comp/{id}', name: 'app_delete_comp')]
    public function deleteTeamComp(TeamComps $teamcomp, EntityManagerInterface $entityManager): Response
    {


        $entityManager->remove($teamcomp);
        $entityManager->flush();
        return $this->redirectToRoute('app_team');
    }
}

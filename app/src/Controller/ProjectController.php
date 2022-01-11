<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/project')]
#[IsGranted('ROLE_USER')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'index_projects')]
    public function index(): Response
    {
        return $this->redirectToRoute('all_projects');
    }

    #[Route('/all', name: 'all_projects')]
    public function all_projects(): Response
    {
        $projects = $this->getUser()->getProjects();

        return $this->render('project/all.html.twig', [
            'projects' => $projects,
        ]);
    }

    // Add a project
    #[Route('/add', name: 'add_project')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->setUser($this->getUser());
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('all_projects');
        }

        return $this->render('project/add.html.twig', [
            'project_form' => $form->createView(),
        ]);
    }

    // Delete Project
    #[Route('/{id}/delete', name: 'delete_project')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $project = $entityManager->getRepository(Project::class)->find($id);
        if ($project){
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('all_projects');
    }

    // Edit project
    #[Route('/{id}/edit', name: 'edit_project')]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = $entityManager->getRepository(Project::class)->find($id);
        if ($project){
            $form = $this->createForm(ProjectType::class, $project);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('all_projects');
            }

            return $this->render('project/edit.html.twig', [
                'project' => $project,
                'project_form' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('all_projects');
    }
}

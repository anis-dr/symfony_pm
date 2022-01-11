<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Form\ProjectType;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/task')]
class TaskController extends AbstractController
{
    // Show project tasks
    #[Route('/{id}', name: 'show_task_per_project')]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $project = $entityManager->getRepository(Project::class)->find($id);
        $tasks = [];
        if ($project){
            $tasks = $project->getTasks();
        }

        return $this->render('task/show.html.twig', [
            'project' => $project,
            'tasks' => $tasks,
        ]);
    }

    #[Route('/{id}/add', name: 'add_task')]
    public function add(int $id,Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = $entityManager->getRepository(Project::class)->find($id);

        if (is_null($project)) {
            return $this->redirectToRoute('all_projects');
        }

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setProject($project);
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('show_task_per_project', ['id' => $project->getId()]);
        }

        return $this->render('task/add.html.twig', [
            'project'=>$project,
            'task_form' => $form->createView(),
        ]);
    }

    // edit task
    #[Route('/{id}/edit', name: 'edit_task')]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = $entityManager->getRepository(Task::class)->find($id);

        if (is_null($task)) {
            return $this->redirectToRoute('all_projects');
        }

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('show_task_per_project', ['id' => $task->getProject()->getId()]);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'task_form' => $form->createView(),
        ]);
    }

    // delete task
    #[Route('/{id}/delete', name: 'delete_task')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $task = $entityManager->getRepository(Task::class)->find($id);

        if (is_null($task)) {
            return $this->redirectToRoute('all_projects');
        }

        $entityManager->remove($task);
        $entityManager->flush();

        return $this->redirectToRoute('show_task_per_project', ['id' => $task->getProject()->getId()]);
    }
}

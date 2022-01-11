<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/project')]
#[IsGranted('ROLE_USER')]
class ProjectController extends AbstractController
{
    #[Route('/all', name: 'all_projects')]
    public function index(): Response
    {
        $projects = $this->getUser()->getProjects();

        return $this->render('project/index.html.twig', [
            'projects' => $projects,
        ]);
    }
}

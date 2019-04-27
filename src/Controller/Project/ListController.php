<?php

namespace App\Controller\Project;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Api\GroomingChimps\Client as GroomingChimpsApiClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/projects", name="project_list")
     */
    public function __invoke(Request $request, GroomingChimpsApiClient $client)
    {
        return $this->render('project/list.html.twig', [
            'projects' => $client->getProjects()['hydra:member'],
            'menu' => 'projects'
        ]);
    }
}

<?php

namespace App\Controller\Project;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Api\GroomingChimps\Client as GroomingChimpsApiClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ListController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/projects", name="project_list")
     */
    public function __invoke(Request $request, GroomingChimpsApiClient $client)
    {
        $data = $client->getProjects($request->query->get('p', '1'));

        return $this->render('project/list.html.twig', [
            'projects' => $data['hydra:member'],
            'pagination' => $data['hydra:view'] ?? false,
            'menu' => 'projects'
        ]);
    }
}

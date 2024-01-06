<?php

namespace App\Controller\Project;

use App\Api\Gobie\Client as GobieApiClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/projects', name: 'project_list')]
    public function __invoke(Request $request, GobieApiClient $client)
    {
        $data = $client->getProjects($request->query->get('p', '1'));

        return $this->render('project/list.html.twig', [
            'projects' => $data['hydra:member'],
            'pagination' => $data['hydra:view'] ?? false,
            'menu' => 'projects',
        ]);
    }
}

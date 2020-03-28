<?php

namespace App\Controller\Project;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Api\GroomingChimps\Client as GroomingChimpsApiClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/projects/{id}/delete", name="project_delete")
     */
    public function __invoke($id, GroomingChimpsApiClient $client)
    {
        $deleted = $client->deleteProject($id);

        if ($deleted) {
            $this->addFlash('success', 'Project was deleted.');
        } else {
            $this->addFlash('failed', 'It failed to delete the project.');
        }

        return $this->redirectToRoute('project_list');
    }
}

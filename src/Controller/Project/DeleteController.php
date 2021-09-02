<?php

namespace App\Controller\Project;

use App\Api\Gobie\Client as GobieApiClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/projects/{id}/delete", name="project_delete")
     */
    public function __invoke($id, GobieApiClient $client)
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

<?php

namespace App\Controller\Job;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Api\GroomingChimps\Client as GroomingChimpsApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    use ControllerTrait;

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/jobs/{id}/delete", name="job_delete")
     */
    public function __invoke($id, GroomingChimpsApiClient $client)
    {
        $deleted = $client->deleteProject($id);

        if ($deleted) {
            $this->addFlash('success', 'Job was deleted.');
        } else {
            $this->addFlash('failed', 'It failed to delete the job.');
        }

        return $this->redirectToRoute('project_list');
    }
}
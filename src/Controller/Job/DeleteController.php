<?php

namespace App\Controller\Job;

use App\Api\Gobie\Client as GobieApiClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/jobs/{id}/delete", name="job_delete")
     */
    public function __invoke($id, GobieApiClient $client)
    {
        $deleted = $client->deleteJob($id);

        if ($deleted) {
            $this->addFlash('success', 'Job was deleted.');
        } else {
            $this->addFlash('failed', 'It failed to delete the job.');
        }

        return $this->redirectToRoute('project_list');
    }
}

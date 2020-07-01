<?php

namespace App\Controller\Job;

use App\Factory\TaskFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Api\GroomingChimps\Client as GroomingChimpsApiClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RerunController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/jobs/{id}/rerun", name="job_rerun")
     */
    public function __invoke($id, Request $request, GroomingChimpsApiClient $client, TaskFactory $factory)
    {
        $client->rerunJob($id, $request->query->get('token', ''));

        $this->addFlash('success', 'Job was queued to rerun.');

        return $this->redirectToRoute('job_view', ['id' => $id]);
    }
}

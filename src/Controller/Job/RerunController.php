<?php

namespace App\Controller\Job;

use App\Api\Gobie\Client as GobieApiClient;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RerunController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/jobs/{id}/rerun', name: 'job_rerun')]
    public function __invoke($id, Request $request, GobieApiClient $client)
    {
        $job = $client->rerunJob($id, $request->query->get('token', ''));

        $this->addFlash('success', 'Job was queued to rerun.');

        return $this->redirectToRoute('job_view', ['id' => $job['id']]);
    }
}

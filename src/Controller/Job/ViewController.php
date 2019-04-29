<?php

namespace App\Controller\Job;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Api\GroomingChimps\Client as GroomingChimpsApiClient;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/jobs/{id}", name="job_view")
     */
    public function __invoke($id, GroomingChimpsApiClient $client)
    {
        $job = $client->getJob($id);

        return $this->render('job/view.html.twig', [
            'job' => $job, 'menu' => 'job_view'
        ]);
    }
}
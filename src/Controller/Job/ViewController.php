<?php

namespace App\Controller\Job;

use App\Api\Gobie\Client as GobieApiClient;
use App\Factory\TaskFactory;
use App\Graph\TaskAggregator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/jobs/{id}", name="job_view")
     */
    public function __invoke($id, GobieApiClient $client, TaskFactory $factory)
    {
        $job = $client->getJob($id);
        $aggregator = new TaskAggregator($factory, $job['tasks']);

        return $this->render('job/view.html.twig', [
            'job' => $job, 'menu' => 'job_view', 'aggregator' => $aggregator,
        ]);
    }
}

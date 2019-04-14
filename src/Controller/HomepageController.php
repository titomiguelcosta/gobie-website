<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\JobSubmitType;
use App\Entity\JobSubmit;
use Symfony\Component\HttpFoundation\Request;
use App\Api\GroomingChimps\Client as GroomingChimpsApiClient;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function __invoke(Request $request, GroomingChimpsApiClient $client)
    {
        $jobSubmit = new JobSubmit();
        $jobSubmit->setBranch('master');

        $form = $this->createForm(JobSubmitType::class, $jobSubmit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $jobSubmit JobSubmit */
            $jobSubmit = $form->getData();
            $project = $client->createProject($jobSubmit->getRepo(), $jobSubmit->isPrivate());
            $job = $client->createJob($project['@id'], $jobSubmit->getBranch());
            $tasks = $client->createTasks($job['@id'], $jobSubmit->getTasks());

            $this->addFlash('success', $jobSubmit->getRepo());

            return $this->redirectToRoute('homepage');
        }

        return $this->render('homepage.html.twig', ['form' => $form->createView()]);
    }
}

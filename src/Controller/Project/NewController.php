<?php

namespace App\Controller\Project;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Factory\TaskFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\JobSubmitType;
use App\Entity\JobSubmit;
use Symfony\Component\HttpFoundation\Request;
use App\Api\GroomingChimps\Client as GroomingChimpsApiClient;
use Symfony\Component\Security\Core\Security;

class NewController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/projects/new", name="project_new")
     */
    public function __invoke(
        Request $request, Security $security, GroomingChimpsApiClient $client, TaskFactory $taskFactory
    ) {
        $jobSubmit = new JobSubmit();
        $jobSubmit->setBranch('master');

        $form = $this->createForm(JobSubmitType::class, $jobSubmit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $jobSubmit JobSubmit */
            $jobSubmit = $form->getData();
            $project = $client->createProject($jobSubmit->getRepo(), $jobSubmit->getDescription(), $jobSubmit->isPrivate());
            $job = $client->createJob($project['@id'], $jobSubmit->getBranch());
            $client->createTasks($job['@id'], $jobSubmit->getTasks());

            $this->addFlash('repo', $jobSubmit->getRepo());

            return $this->redirectToRoute('homepage');
        }

        return $this->render('project/new.html.twig', [
            'form' => $form->createView(), 'menu' => 'homepage', 'taskFactory' => $taskFactory
        ]);
    }
}

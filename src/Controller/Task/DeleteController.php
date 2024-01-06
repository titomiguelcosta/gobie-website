<?php

namespace App\Controller\Task;

use App\Api\Gobie\Client as GobieApiClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * #[IsGranted("ROLE_USER")]
     * #[Route("/tasks/{id}/delete", name="task_delete")]
     */
    public function __invoke($id, GobieApiClient $client)
    {
        $deleted = $client->deleteTask($id);

        if ($deleted) {
            $this->addFlash('success', 'Task was deleted.');
        } else {
            $this->addFlash('failed', 'It failed to delete the task.');
        }

        return $this->redirectToRoute('project_list');
    }
}

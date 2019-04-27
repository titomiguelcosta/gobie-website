<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomepageController extends AbstractController
{
    use ControllerTrait;

    /**
     * @Route("/", name="homepage")
     */
    public function __invoke(Security $security)
    {
        if ($security->getUser() instanceof User) {
            return $this->redirectToRoute('project_list');
        }

        return $this->render('homepage.html.twig', [
            'menu' => 'homepage'
        ]);
    }
}

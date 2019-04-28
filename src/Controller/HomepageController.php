<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EarlyAccessType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomepageController extends AbstractController
{
    use ControllerTrait;

    /**
     * @Route("/", name="homepage")
     */
    public function __invoke(Request $request, Security $security, \Swift_Mailer $mailer)
    {
        if ($security->getUser() instanceof User) {
            return $this->redirectToRoute('project_list');
        }

        $form = $this->createForm(EarlyAccessType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $message = (new \Swift_Message('Grooming Chimps: Early Access Request'))
                ->setFrom('groomingchimps@titomiguelcosta.com')
                ->setTo($data['email'])
                ->setBcc('groomingchimps@titomiguelcosta.com')
                ->setBody(
                    'Hello, thanks for your interest. We got your request. In the upcoming assembly, the chimps will decide if we are ready to welcome you. Bear with us.',
                    'text/plain'
                );

            $mailer->send($message);

            $this->addFlash('email', $data['email']);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('homepage.html.twig', [
            'menu' => 'homepage',
            'form' => $form->createView()
        ]);
    }
}

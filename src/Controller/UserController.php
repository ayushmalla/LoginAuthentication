<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * #[Route('/user', name: 'user')]
     */
    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        $registration = new User();
        $form = $this->createForm(UserType::class, $registration);
        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

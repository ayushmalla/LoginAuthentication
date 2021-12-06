<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/view', name: 'view.')]
class ViewController extends AbstractController
{
    /**
     * @var EntityMangaerInterface
     */
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        
        
    }
    #[Route('/', name: 'index')]
    public function index(UserRepository $userRepository): Response
    {
        $user = $userRepository->findAll();
        return $this->render('view/index.html.twig', [
            'view'=> $user,
        ]);
    }

    /**
     * @param user $User
     */
    #[Route('/show/{id}', name: 'show')]
    public function show(User $user): Response
    {
        $title = $user->getTitle();
        $image = $user->getImage();
        return $this->render('view/title.html.twig', [
            'title' => $title,
            'image' => $image
             ,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(User $user): Response
    {
        
        $id = $user->getId();
        $this->em->remove($user);
        $this->em->flush($user);


        $this->addFlash('success','Post ' .$id. ' is Removed!!!!');
        return $this->redirect($this->generateUrl('view.index'));
    }
}

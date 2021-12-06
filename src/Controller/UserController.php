<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\TestRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Symfony\Component\Form\FileUploadError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @var ORMEntityManagerInterface
     */
    private $em;

    public function __construct(ORMEntityManagerInterface $em)
    {
        $this->em = $em;
        
    }
    
    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        $registration = new User();
        $form = $this->createForm(UserType::class, $registration);
        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
            // 'title'=> "",
            // 'file'=> "",
        ]);
    }

     #[Route("/insert", name:"insert")]
    public function insert(Request $request, FileUploader $fileUploader, TestRepository $tp){   
         
        $user= new User();

        $test = new Test();


        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);

        if($form->isSubmitted()){
            
        /** @var UploadedFile $file */
        $file = $request->files->get('user')['attachment'];
        
        $title = $form->get('Title')->getData();

        // dump($request);
        if($file){
            
            $filename = $fileUploader->upload($file);
            
            $user->setImage($filename);
            $user->setTitle($title);
            // $user->setTest();
            
        }
        
        $this->em->persist($user);
        $this->em->flush();

        $this->addFlash('success','Post Successfully Added!!!!');

        return $this->redirectToRoute('view.index');
        }
        // dump($_GET['username']);
        // $all = $tp->findByUsername($_GET['username']);

        // dump($all);
        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
            // 'all' => $all,

        ]);
    
    }
}

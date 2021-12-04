<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
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
    public function insert(Request $request, FileUploader $fileUploader){   
         
        $user= new User();
        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);

        if($form->isSubmitted()){
            
        // dump($user);
        // dump($request);

        /** @var UploadedFile $file */
        $file = $request->files->get('user')['attachment'];
        
        $title = $form->get('Title')->getData();

        // dump($request);
        if($file){
            
            // $filename = $fileUploader->upload($file);
            $filename= md5(uniqid()) . '.' . $file->guessClientExtension();
            
            try{
            $file->move(
                //TODO: get target directory
                $this->getParameter('image_dir'),
                $filename 
            );
        }catch(FileException $e){
            $e;
            }
            
            $user->setImage($filename);
            $user->setTitle($title);
            
        }
        
        $this->em->persist($user);
        $this->em->flush();

        return $this->redirectToRoute('insert');
        }
        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
        ]);
    
    }
}

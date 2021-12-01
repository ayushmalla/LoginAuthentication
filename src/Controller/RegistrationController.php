<?php

namespace App\Controller;

use App\Entity\Test;
use App\Form\TestType;
use App\Service\RegistrationValidation;
use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use ORM\Doctrine\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegistrationController extends AbstractController
{

    /**
     * @var ORMEntityManagerInterface
     */
    private $em;

    public function __construct(ORMEntityManagerInterface $em)
    {
        $this->em = $em;
        
    }

    #[Route('/register', name: 'register')]
    public function register( Request $request, UserPasswordEncoderInterface $PasswordEncoder): Response
    {
        
        $user= new Test();
        $form = $this->createForm(TestType::class, $user);
    
        
        $form->handleRequest($request);

            if($form->isSubmitted()){
                // $data = $form->getData();

                $user = new Test();

                
                $user->setUsername($form->get('username')->getData());
                $user->setRoles($form->get('roles')->getData());
                //getting entered password from the form
            $password = $form->get('password')->getData();

            //password Validation
            if (strlen($password) <= '5') {
                return $this->redirectToRoute('register',[ $this->addFlash('error', 'Your Password Must Contain At Least 5 Characters!')]);
            }
            elseif(!preg_match("#[0-9]+#",$password)) {
                
                return $this->redirectToRoute('register',[$this->addFlash('error', 'Your Password Must Contain At Least 1 Number!') ]);
            }
            elseif(!preg_match("#[A-Z]+#",$password)) {
                return $this->redirectToRoute('register',[ $this->addFlash('error', 'Your Password Must Contain At Least 1 Capital Letter!')]);
            }
            elseif(!preg_match("#[a-z]+#",$password)) {
                return $this->redirectToRoute('register',[ $this->addFlash('error', 'Your Password Must Contain At Least 1 Lowercase Letter!')]); 
            }else{
            $user->setPassword(
                $PasswordEncoder->encodePassword($user, $form->get('password')->getData())
            );
        }
        dump($user);
                
                // $em =  $this->getdoctrine()->getManager();

                $this->em->persist($user);
                $this->em->flush();
             
                return $this->redirect($this->generateUrl('app_login'));

        }
            return $this->render('registration/index.html.twig', [
            'form'=> $form->createView()
        ]);
    
    }
}

<?php

namespace App\Controller;

use App\Entity\Exp;
use App\Entity\Test;
use App\Form\TestType;
use App\Service\RegistrationValidation;
use Doctrine\Common\Collections\ArrayCollection;
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
    public function register( Request $request,UserPasswordEncoderInterface $PasswordEncoder): Response
    {
        
        $user= new Test();
        
        // $user->setUsername('Hello');
        // $exp = new Exp();
        
        // $exp->setTitle("java");
        // $exp->setLocation("Baneshwor");
        // $exp->setDateFrom(new \DateTime());
        // $exp->setDateTo(new \DateTime());

        // $exp->setTest($user);

        // $user->addExp($exp);
        
        $form = $this->createForm(TestType::class, $user);
        // dump($user);
        
        // $orignalExp = new ArrayCollection();
        // foreach ($user->getExp() as $exp) {
        //     $orignalExp->add($exp);
        // }
        
        $form->handleRequest($request);

            if($form->isSubmitted()){
                // $data = $form->getData();
                // dump($user);
                
                // $user->setUsername($form->get('username')->getData());
                // $user->setRoles($form->get('roles')->getData());
                // $user->setAddress(($form->get('address')->getData()));
                
            
                // $user->addExp($form->get('exp')->getData());
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
                
            // dump($user);
                $this->em->persist($user);
                $this->em->flush();
             
                $this->addFlash('success','User Registered Successfully!!!!');
                return $this->redirect($this->generateUrl('app_login'));

        }
            return $this->render('registration/index.html.twig', [
            'form'=> $form->createView()
        ]);
    
    }
}

<?php

namespace App\Controller;

use App\Entity\Test;
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
        $this->$em = $em;
        
    }
    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordEncoderInterface $PasswordEncoder): Response
    {
        $form = $this->createFormBuilder()
            ->add('username')
            ->add('password', RepeatedType::class, [
                'type'=> PasswordType::class,
                'required'=> true,
                'first_options'=>['label' =>'Password'],
                'second_options'=> ['label'=>'Confirm Password']
            ])
            ->add('register', SubmitType::class,[
                'attr'=>[
                    'class' => 'btn btn-success float-left'
                ]
            ])
            ->getForm();
            
            $form->handleRequest($request);

            if($form->isSubmitted()){
                $data = $form->getData();

                $user = new Test();

                $user->setUsername($data['username']);
                $user->setPassword(
                    $PasswordEncoder->encodePassword($user, $data['password'])
                );
                dump($user);

                $em =  $this->getdoctrine()->getManager();
                
                $em->persist($user);
                $em->flush();

                return $this->redirect($this->generateUrl('app_login'));

            }
        return $this->render('registration/index.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
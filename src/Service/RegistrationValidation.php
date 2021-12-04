<?php


namespace App\Service;

use App\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Serializer;

class RegistrationValidation extends AbstractController{

    public function passwordValidator($password,UserPasswordEncoderInterface $PasswordEncoder,$form){
        
        $user = new Test();
      
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
    }


    
 } 

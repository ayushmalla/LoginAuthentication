<?php


namespace App\Service;

use App\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationValidation extends AbstractController{

//     /**
//      * @var UserPasswordEncoder
//      */
//     private $PasswordEncoder = new UserPasswordEncoderInterface();

//     private $request = new Request();

//  public function Validator(){
//         $user= new Test();
//         $form = $this->createForm(TestType::class, $user);
    
        
//         $form->handleRequest($this->request);

//         if($form->isSubmitted()){
//             // $data = $form->getData();

//             // $user = new Test();
            
//             $user->setUsername($form->get('username')->getData());


//             $user->setRoles($form->get('roles')->getData());

//             //getting entered password from the form
//             $password = $form->get('password')->getData();

//             //password Validation
//             if (strlen($password) <= '8') {
//                 return $this->redirectToRoute('form',[ $this->addFlash('error', 'Your Password Must Contain At Least 8 Characters!')]);
//             }
//             elseif(!preg_match("#[0-9]+#",$password)) {
                
//                 return $this->redirectToRoute('form',[$this->addFlash('error', 'Your Password Must Contain At Least 1 Number!') ]);
//             }
//             elseif(!preg_match("#[A-Z]+#",$password)) {
//                 return $this->redirectToRoute('form',[ $this->addFlash('error', 'Your Password Must Contain At Least 1 Capital Letter!')]);
//             }
//             elseif(!preg_match("#[a-z]+#",$password)) {
//                 return $this->redirectToRoute('form',[ $this->addFlash('error', 'Your Password Must Contain At Least 1 Lowercase Letter!')]); 
//             }else{
//             $user->setPassword(
//                 $this->PasswordEncoder->encodePassword($user, $form->get('password')->getData())
//             );
//         }
//             dump($user);

            
//             $em =  $this->getdoctrine()->getManager();

//             $em->persist($user);
//             $em->flush();

            
//             return $this->redirect($this->generateUrl('app_login'));
//         }
// }
 } 

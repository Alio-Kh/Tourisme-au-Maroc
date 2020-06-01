<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('accuiel');
    }
     /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(UserRepository $userRepository,Request $request,UserPasswordEncoderInterface $userPasswordEncoderInterface){
        $user =new User();
        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $password=$userPasswordEncoderInterface->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
            $user->setRoles(["ROLE_USER"]);
            $email=$userRepository->findOneBy(array('email'=>$user->getEmail()));
              if(!empty($email)){
                  $this->addFlash('message','email exist');
                  return $this->redirectToRoute('inscription');
             }
             $entityManager=$this->getDoctrine()->getManager();
             $entityManager->persist($user);
             $entityManager->flush();
             
             $ville=$request->getSession()->get('ville');
             if( $ville!=null){
               return new RedirectResponse('/'.$ville.'/details');
             }
               return $this->redirectToRoute('home');

        }

        return $this->render('security/inscription.html.twig',['form' => $form->createView()]);

    }
}

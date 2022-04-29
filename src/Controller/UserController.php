<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Security\FormLoginAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Form\RegistrationFormType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
  /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // retrouver une erreur d'authentification s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // retrouver le dernier identifiant de connexion utilisé
        $lastUsername = $authenticationUtils->getLastUsername();
        // $user = new User();
        // $form = $this->createForm(RegistrationFormType::class, $user);
        // $form->handleRequest($request);
        
        // dump($form);
        //$password = $passwordEncoder->isPasswordValid($user,$_POST['password']);
        
        //#Récupérer les données du form
        //#Comparer mail & password pour vérif 
        
        
        // if(isset($lastUsername) && !empty($lastUsername)){
        //     return $this->redirect('home');
        // }
        
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            ]
        );
    }
      /**
      * @Route("/signup", name="sign_up")
      */
    public function signUp(GuardAuthenticatorHandler $guard, Request $request, FormLoginAuthenticator $formLogin, UserPasswordEncoderInterface $passwordEncoder): Response 
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));
            $user->setRoles(['ROLE_USER']);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // do anything else you need here, like send an email

        return $this->redirect('home');
        }
    
    return $this->render('security/signup.html.twig', [
        'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
    /**
     * @Route("/resetpassword", name="reset_password")
     */
    public function passwordRecovery(){
        dump($_POST);
        return $this->render('security/reset_password.html.twig');
    }

    
}

<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
    /**
     * @Route("/sendmail")
     */
    public function sendMail(MailerInterface $mailer): Response{
        
        $email = (new Email())->from('julien.felici@gmail.com')
        ->to('julien.felici@gmail.com')
        ->subject('Testing Mail')
        ->text('Hello');
        dump($email);

        $mailer->send($email);
        return $this->render('security/reset_password.html.twig');
    }  
    
}

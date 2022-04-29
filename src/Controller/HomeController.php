<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Figure;
use App\Repository\FigureRepository;

class HomeController extends AbstractController
{  
     /**
     * @Route("/home", name="home")
     */
    public function displayHome(FigureRepository $repo): Response
    {
        
        $figure = new Figure;
        $tricks = $repo->findAll();

         
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController','tricks' => $tricks
        ]);
    }
}

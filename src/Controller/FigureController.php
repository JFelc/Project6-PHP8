<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Figure;
use App\Entity\Photo;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\FigureRepository;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;

class FigureController extends AbstractController
{
    /**
     * @Route("/tricks/{id}", name="figure")
     */
    public function displayFigure(FigureRepository $repo): Response
    {
        
        $url = $_SERVER['REQUEST_URI'];
        $exploded = explode('/',$url);
        $figure = new Figure();
        $tricks = $repo->find($exploded[2]);
        //var_dump($tricks);
        //$finalGroupe = $repo->find($tricks->groupe->id);


         
        return $this->render('figure/index.html.twig', [
            'controller_name' => 'FigureController','tricks' => $tricks
        ]);
    }
    /**
     * @Route("/tricks/new")
     */
    public function createFigure(Request $request){
          $tricks = new Figure();

        $form = $this->createFormBuilder($tricks)
            ->add('nom', TextType::class)
            ->add('groupe', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Valider'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $tricks = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($tricks);
            $em->flush();

            echo 'Envoyé';
        }

        return $this->render('figure/index.html.twig', [
            'controller_name' => 'FigureController','tricks' => $tricks
        ]);
    }
    /**
     * @Route("/tricks/delete/{id}", name="deleteFigure")
     */

    public function delete(PhotoRepository $photoRepo,EntityManagerInterface $manager): Response
    {
        $url = $_SERVER['REQUEST_URI'];
        $exploded = explode('/',$url);

        $photo = $photoRepo->find($exploded[2]);
        $figure = $photo->getFigure();
        //$figure->removePhoto($photo);
        $manager->remove($figure);
        $manager->flush();
        
        return $this->render('temp.html.twig', [
            'controller_name' => 'FigureController', 'figure'=>$figure
        ]);
    }
}

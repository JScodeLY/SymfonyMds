<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="app_default")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
     /**
     * @Route("/default1", name="app_default1")
     */
    public function test1() 
    {
        return new Response("Hello");
    }
     /**
     * @Route("/blog/{param}", name="demo1",requirements={"param" = "\d+"})
     */
    public function list(int $param) 
    {
        return new Response("voici le paramètre de l'URL".$param);
    }
     /**
     * @Route("/blog/{slug}", name="demo2")
     */
    public function list1($slug) 
    {
        return new Response("demo2, voicie le paramètre de l'URL". $slug);
    }
     /**
     * @Route("/deconnexion/{nom}", name="demo3")
     */
    public function deconnexion($nom) 
    {
        return new Response("Salut ".$nom);
    }
     /**
     * @Route("/deconnexion/{nom?Utilisateur}", name="demo4")
     */
    public function deconnexion1($nom) 
    {
        return new Response("Salut ". $nom);
    }
}

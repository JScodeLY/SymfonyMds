<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/base", name="base")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }
    /**
     * @Route("/home", name="home")
     */
    public function home(): Response
    {
        $tableau = array(
            "1" => array("id"=>1,"nom" => "Lebron", "prenom" => "James", "Number" => "0123456789"),
            "2" => array("id"=>2,"nom" => "Lebron", "prenom" => "James", "Number" => "0123456789"),
            "3" => array("id"=>3,"nom" => "Lebron", "prenom" => "James", "Number" => "0123456789")
        );
        return $this->render('home.html.twig', [
            "contacts" => $tableau
        ]);
    }
}

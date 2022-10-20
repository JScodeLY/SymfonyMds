<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\Persistence\ManagerRegistry;
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
    public function home(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $contacts = $entityManager->getRepository(Contact::class)->findAll();
        $entityManager->flush();
        // $tableau = array(
        //     "1" => array("id"=>1,"nom" => "Lebron", "prenom" => "James", "Number" => "0123456789"),
        //     "2" => array("id"=>2,"nom" => "Lebron", "prenom" => "James", "Number" => "0123456789"),
        //     "3" => array("id"=>3,"nom" => "Lebron", "prenom" => "James", "Number" => "0123456789"),
        // );

        // dd(
        // $contacts
        // );
        return $this->render('home.html.twig', [
            "contacts" => $contacts
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('contact.html.twig');
    }
    // /**
    //  * @Route("/contact/all", name="allContact")
    //  */
    // public function allContact(): Response
    // {
    //     return $this->render('contact.html.twig');
    // }
}

<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\FormAddContactType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{
    /**
     * @Route("/createContact", name="app_contact")
     */
    public function createContact(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $contact = new Contact();
        $contact->setNom("LY");
        $contact->setPrenom("Francois");
        $contact->setTelephone(0201020304);
        $contact->setAdresse("00 rue du dev");
        $contact->setVille("Symfony");
        $contact->setAge(16);

        $entityManager->persist($contact);

        $entityManager->flush();

        return new Response("Saved new product with id" . $contact->getId());
    }
    /**
     * @Route("/contact/all", name="findAllContact")
     */
    public function findAllContact(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $contacts = $entityManager->getRepository(Contact::class)->findAll();

        // dd($contacts);
        // if (!$contact){
        //     throw $this->createNotFoundException(
        //         'Not product found for id'.$id
        //     );
        // }

        $entityManager->flush();

        return $this->render(
            'home.html.twig',
            [
                "contacts" => $contacts
            ]
        );
    }
    /**
     * @Route("/contact/{id}", name="findContact")
     */
    public function findContact(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $contact = $entityManager->getRepository(Contact::class)->find($id);

        // dd($contacts);
        // if (!$contact){
        //     throw $this->createNotFoundException(
        //         'Not product found for id'.$id
        //     );
        // }

        $entityManager->flush();
        // dd($contact);
        return $this->render(
            'contact.html.twig',
            [
                "contact" => $contact,
                "nom" => $contact->getNom(),
                "prenom" => $contact->getPrenom()
            ]
        );
    }
    /**
     * @Route("/contact/update/{id}", name="updateTelephoneContact")
     */
    public function updateTelephoneContact(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $contact = $entityManager->getRepository(Contact::class)->find($id);
        // $contacts = $entityManager->getRepository(Contact::class)->findAll();
        // dd($contacts);
        // if (!$contact){
        //     throw $this->createNotFoundException(
        //         'Not product found for id'.$id
        //     );
        // }
        $contact->setTelephone("New Telephone");

        $entityManager->persist($contact);
        $entityManager->flush();
        // dd($contact);
        return $this->redirectToRoute('findAllContact');
    }
    /**
     * @Route("/contact/delete/{id}", name="deleteContact")
     */
    public function deleteContact(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $contact = $entityManager->getRepository(Contact::class)->find($id);
        // $contacts = $entityManager->getRepository(Contact::class)->findAll();
        // dd($contacts);
        if (!$contact) {
            throw $this->createNotFoundException(
                'Not contact found for id' . $id
            );
        }
        $entityManager->remove($contact);
        // $entityManager->persist($contacts);

        $entityManager->flush();
        // dd($contact);
        return $this->redirectToRoute(
            'findAllContact',
            []
        );
    }
    /**
     * @Route("/contact/age/{age}", name="findContactByAge")
     */
    public function findContactByAge(ManagerRegistry $doctrine, int $age): Response
    {
        $entityManager = $doctrine->getManager();

        $contacts = $entityManager->getRepository(Contact::class)->findByAge($age);

        // dd($contacts);
        // if (!$contact){
        //     throw $this->createNotFoundException(
        //         'Not contact found for age is '.$id
        //     );
        // }

        // $entityManager->persist($contacts);

        // $entityManager->flush();
        // dd($contact);
        return $this->render(
            'home.html.twig',
            [
                "contacts" => $contacts,

            ]
        );
    }
    /**
     * @Route("/addContact", name="addContact")
     */
    public function addContact(ManagerRegistry $doctrine, Request $request): Response
    {
        $contact = new Contact();

        $form = $this->createForm(FormAddContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash(
                'add_contact',
                'Votre contact a bien été rajouté '
            );
            return $this->redirectToRoute('findAllContact');
        }

        return $this->renderForm('contact/ajouter.html.twig', [
            'formulaireContact' => $form
        ]);
    }
    /**
     * @Route("/updateContact/{id}", name="updateContact")
     */
    public function updateContact(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $contact = $entityManager->getRepository(Contact::class)->find($id);

        $form = $this->createForm(FormAddContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash(
                'add_contact',
                'Votre contact a bien été modifié '
            );
            return $this->redirectToRoute('findAllContact');
        }

        return $this->renderForm('contact/modifier.html.twig', [
            'formulaireUpdateContact' => $form
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="app_product")
     */
    public function createProduct(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName("Keyboard");
        $product->setPrice(1999);
        $product->setDescription("Fabuleux et rétroéclairé");
        
        $entityManager->persist($product);

        $entityManager->flush();

        return new Response("Saved new product with id".$product->getId());
    }
    /**
     * @Route("/product/edit/{id}", name="editProduct")
     */
    public function updateProduct(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product){
            throw $this->createNotFoundException(
                'Not product found for id'.$id
            );
        }
        $product->setName("New product Name");
        

        $entityManager->flush();

        return $this->redirectToRoute('home',[
            $id =>$product->getId()
        ]
        );
    }
    /**
     * @Route("/product/delete/{id}", name="deleteProduct")
     */
    public function deleteProduct(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product){
            throw $this->createNotFoundException(
                'Not product found for id'.$id
            );
        }
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }
    /**
     * @Route("/product/price/{price}", name="findAllGreaterThanPrice")
     */
    public function findProductPrice(ManagerRegistry $doctrine, int $price): Response
    {
        $entityManager = $doctrine->getManager();

        $products = $entityManager->getRepository(Product::class)->findAllGreaterThanPrice($price);

        dd($products);
        // if (!$product){
        //     throw $this->createNotFoundException(
        //         'Not product found for id'.$id
        //     );
        // }
       

        return $this->redirectToRoute('home',[
            "produits"=>$products
        
        ]);
    }
    /**
     * @Route("/addProduct", name="addProduct")
     */
    public function addProduct(ManagerRegistry $doctrine , Request $request): Response
    {
        

        $product = new Product();
       
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager=$doctrine->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash(
                'add_product',
                'Votre produit a bien été rajouté '
            );
            return $this->redirectToRoute('home');
        }

        return $this->renderForm('Products/addProduct.html.twig',[
            'formulaireProduit'=>$form
        ]);
    }
}

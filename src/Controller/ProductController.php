<?php

namespace App\Controller;

use PhpParser\ErrorHandler\Throwing;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'product_index')]
    public function index(ProductRepository $pRepo): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $pRepo->findAll(), 
        ]);   
    }

    #[Route('/product/{id<\d+>}', name: 'product_show')]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
           'product' => $product
        ]);
    }
    #[Route('/product/create', name: 'product_create')]
    public function create(Request $request, EntityManagerInterface $manager): Response{


    $product = new Product();

     $form = $this->createForm(ProductType::class, $product);

     $form->handleRequest($request);

     if ($form->isSubmitted()) {

            $manager->persist($product);
            $manager->flush();

        return $this->redirectToRoute('product_show',
         ['id' => $product->getId()
         ]);
     }
    
        return $this->render('product/create.html.twig', [
            'controller_name' => 'ProductController',
            'form'=> $form,
        ]);

    }
}

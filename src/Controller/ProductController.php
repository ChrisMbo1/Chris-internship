<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
final class ProductController extends AbstractController
{
    #[Route('/product', name: 'product_index')]
    public function index(ProductRepository $pRepo): Response
    {

    $products = $pRepo->findAll();

    dd($products);

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products, 
        ]);   
    }
}

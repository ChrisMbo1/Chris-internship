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
use PhpParser\Node\Scalar\MagicConst\Method;
use Symfony\Component\HttpFoundation\JsonResponse;


final class ProductController extends AbstractController
{

  /*   #[Route('/product', name: 'product_index')]
    public function index(ProductRepository $pRepo): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $pRepo->findAll(),
        ]);
    }
 */


// Rename the function to 'index' to match what Symfony is looking for
#[Route('/product', name: 'product_index', methods: ['GET'])]
public function index(ProductRepository $pRepo): JsonResponse
{
    $products = $pRepo->findAll();

    $data = [];
    foreach ($products as $product) {
        $data[] = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'description' => $product->getDescription(),
            'quantity' => $product->getQuantity(),
        ];
    }

    return new JsonResponse($data);
}

#[Route('/product/create', name: 'product_create', methods: ['POST'])]
public function create(Request $request, EntityManagerInterface $manager): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    $product = new Product();
    $product->setName($data['name']);
    $product->setPrice($data['price']);
    $product->setDescription($data['description']);
    $product->setQuantity($data['quantity'] ?? 0);

    $manager->persist($product);
    $manager->flush();

    return new JsonResponse(['id' => $product->getId()], 201);
}


    #[Route('/product/{id<\d+>}', name: 'product_show')]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
           'product' => $product
        ]);
    }


#[Route('/product/{id<\d+>}/edit', name: 'product_edit', methods: ['PUT'])]
public function edit( int $id, Request $request, EntityManagerInterface $manager, ProductRepository $pRepository):JsonResponse
{
    $product = $pRepository->find($id);

    if (!$product) {
        return new JsonResponse(['error' => 'Product not found'], 404);
    }

    $data = json_decode($request->getContent(), true);

    $product->setName($data['name']);
    $product->setPrice($data['price']);
    $product->setDescription($data['description']);
    $product->setQuantity($data['quantity'] ?? $product->getQuantity());

    $manager->flush();

    return new JsonResponse(['status' => 'Product updated'], 202);
}




/*     #[Route('/product/create', name: 'product_create')]
    public function create(Request $request, EntityManagerInterface $manager): Response{

    $product = new Product();

     $form = $this->createForm(ProductType::class, $product);

     $form->handleRequest($request);

     if ($form->isSubmitted()) {

            $manager->persist($product);
            $manager->flush();

            $this->addFlash(
                '',
                'Product created successfully!');

        return $this->redirectToRoute('product_show',
         ['id' => $product->getId()
         ]);

         return $this->redirectToRoute('product_index', [
         ]);
     }

        return $this->render('product/create.html.twig', [
            'controller_name' => 'ProductController',
            'form'=> $form,
        ]);

    }
 */


/*     #[Route('/product/{id<\d+>}/edit', name: 'product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $manager): Response
    {

    $form = $this->createForm(ProductType::class, $product);

     $form->handleRequest($request);

     if ($form->isSubmitted()) {

            $manager->flush();

            $this->addFlash(
                'notice',
                'Product updated successfully!');

               return $this->redirectToRoute('product_index', [
         ]);
     }

        return $this->render('product/edit.html.twig', [
            'controller_name' => 'ProductController',
            'form'=> $form,
        ]);
    } */




    #[Route('/product/{id<\d+>}/delete', name: 'product_delete')]

    public function delete(Product $product, EntityManagerInterface $manager): Response
    {
        $manager->remove($product);
        $manager->flush();

        $this->addFlash(
            'notice',
            'Product deleted successfully!');

        return $this->redirectToRoute('product_index', [
        ]);
    }
}

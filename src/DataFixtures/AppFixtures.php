<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $product = new Product();
         $product->setName("Product 1");
         $product->setPrice(9.99);
         $product->setQuantity(10);
         $product->setDescription("Description for Product 1");

         $manager->persist($product);

        $product = new Product();
         $product->setName("Product 2");
         $product->setPrice(19.99);
         $product->setQuantity(5);
         $product->setDescription("Description for Product 2");
         
         $manager->persist($product);


        $manager->flush();
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LuckyController extends AbstractController
{

   #[Route('/lucky' , name:'lucky_index')]
    public function number(): Response
    {
        $number = random_int(100, 10000);

        return $this->render('lucky/index.html.twig', [
            'number' => $number,
        ]);
    }
}

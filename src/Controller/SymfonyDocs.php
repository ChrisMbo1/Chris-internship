<?php

namespace App\Controller;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class SymfonyDocs extends AbstractController
{

const API_URL = 'https://api.github.com/repos/symfony/symfony-docs';
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    #[Route('/docs', name: 'symfony_docs')]
    public function fetchGitHubInformation(): JsonResponse
    {
        $response = $this->client->request(
            'GET',
            self::API_URL
        );

        $data = $response->toArray();

        dd($data);
    }
}
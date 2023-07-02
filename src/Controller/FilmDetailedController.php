<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class FilmDetailedController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }
    
    public function GetResultForId(int $seekId)
    {
        $urlToSeek = $this->getParameter('tmdbMainUrl') . '/movie/' . $seekId . '?';

        $response = $this->client->request(
            'GET',
            $urlToSeek,
            [
                'headers' => [
                    'Authorization' => $this->getParameter('tmdbAccessKey'),
                    'accept' => 'application/json',
                ],
            ]
        );

        $jsonRaw = json_decode($response->getContent(), true);

        return $jsonRaw;
    }

    #[Route('/film/{vid}', name: 'film')]
    public function index(int $vid): Response
    {
        $movie = $this->GetResultForId($vid);
        // dd($movie);

        return $this->render('film_detailed/index.html.twig', [
            'movie' => $movie,
        ]);
    }
}

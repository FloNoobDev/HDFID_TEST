<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;


class FilmDetailedController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
        private RequestStack $requestStack,
    ) {
    }

    public function GetResultForId(int $seekId, string|null $language)
    {
        if($language){
            $urlToSeek = $this->getParameter('tmdbMainUrl') . '/movie/' . $seekId . '?' . $language;
        }
        else{
            $urlToSeek = $this->getParameter('tmdbMainUrl') . '/movie/' . $seekId . '?&language=fr-FR' ;
        }

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
        $session = $this->requestStack->getSession();
        $language = $session->get('language') ? '&language='. $session->get('language') : null;

        $movie = $this->GetResultForId($vid,$language);

        return $this->render('film_detailed/index.html.twig', [
            'movie' => $movie,
        ]);
    }
}

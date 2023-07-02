<?php

namespace App\Controller;

use App\Form\MoviesType;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FilmsController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function GetPopularMovies()
    {
        $urlToSeek = $this->getParameter('tmdbMainUrl') . '/movie/popular?language=en-US&page=1';

        $response = $this->client->request('GET', $urlToSeek, [
            'headers' => [
                'Authorization' => $this->getParameter('tmdbAccessKey'),
                'accept' => 'application/json',
            ],
        ]);

        $jsonRaw = json_decode($response->getContent(), true);

        return $jsonRaw;
    }
    public function GetResultsByName(string $seek, string $language)
    {

        $urlToSeek = $this->getParameter('tmdbMainUrl') . '/search/movie?query=' . $seek . '&include_adult=false&language=' . $language;

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

    #[Route('/films', name: 'films')]
    public function index(Request $request): Response
    {
        $moviesForm = $this->createForm(MoviesType::class);
        $movies = $this->GetPopularMovies();

        $moviesForm->handleRequest($request);

        if ($moviesForm->isSubmitted() && $moviesForm->isValid()) {
            $formData = $moviesForm->getData();

            if($formData['honeypot']){
                $this->redirectToRoute('index');
            }

            $movies = $this->GetResultsByName($formData['title'], $formData['language']);
        }

        return $this->render('films/index.html.twig', [
            'moviesForm' => $moviesForm->createView(),
            'movies' => $movies,
        ]);
    }
}
<?php

namespace App\Controller;

use App\Entity\Movies;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;


class FilmsController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function GetResultsByName(string $seek, string $language)  {

        $urlToSeek = 'https://api.themoviedb.org/3/search/movie?query=' . $seek .'&include_adult=false&language=' . $language;

        $response = $this->client->request(
            'GET',
            $urlToSeek,
            [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyM2RiMmZhMmZiMWNiM2YwYTFmNDJlN2NjNTQ4YmU4MCIsInN1YiI6IjVjY2JlZjI1OTI1MTQxMDQ1ZDI2YzkyNCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.Up9sJcfYAEahEK-NH8fyPbNr9q801QQrQI29qS27r2o',
                    'accept' => 'application/json',
                ],
            ]
        );  
        
        $jsonRaw = json_decode($response->getContent(),true);

        return $jsonRaw;
    }

    #[Route('/films', name: 'films')]
    public function index(): Response
    {

        dd($this->GetResultsByName('jumanji','en-US'));

        return $this->render('films/index.html.twig', [
            'movies' =>$this->GetResultsByName('jumanji','en-US'),
        ]);
    }
}

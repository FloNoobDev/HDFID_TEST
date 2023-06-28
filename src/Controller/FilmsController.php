<?php

namespace App\Controller;

use App\Entity\Movies;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Console\Helper\ProgressBar;


class FilmsController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function GetResultsByName(string $seek, string $language)  {

        $urlToSeek = $this->getParameter('tmdbMainUrl'). '/movie?query=' . $seek .'&include_adult=false&language=' . $language;

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
        
        $jsonRaw = json_decode($response->getContent(),true);

        return $jsonRaw;
    }

    #[Route('/films', name: 'films')]
    public function index(): Response
    {
        // dd($this->GetResultsByName('jumanji','en-US'));

        return $this->render('films/index.html.twig', [
            'movies' =>$this->GetResultsByName('jumanji','en-US'),
        ]);
    }
}

<?php

namespace App\CustomClass;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenericClass extends AbstractController
{
    public function __construct(
        protected HttpClientInterface $client,
        protected RequestStack $requestStack,
    ) {
    }

    public function GetPopularMovies()
    {
        $urlToSeek = $this->getParameter('tmdbMainUrl') . '/movie/popular?language=fr-FR&page=1';

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

    public function GetResultForId(int $seekId, string|null $language)
    {
        if ($language) {
            $urlToSeek = $this->getParameter('tmdbMainUrl') . '/movie/' . $seekId . '?' . $language;
        } else {
            $urlToSeek = $this->getParameter('tmdbMainUrl') . '/movie/' . $seekId . '?&language=fr-FR';
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


    public function GetPopularPeople()
    {
        $urlToSeek = $this->getParameter('tmdbMainUrl') . '/trending/person/week?language=fr-FR';

        $response = $this->client->request('GET', $urlToSeek, [
            'headers' => [
                'Authorization' => $this->getParameter('tmdbAccessKey'),
                'accept' => 'application/json',
            ],
        ]);

        $jsonRaw = json_decode($response->getContent(), true);

        return $jsonRaw;
    }
    public function GetPeopleByName(string|null $name, string $language)
    {
        $urlToSeek = $this->getParameter('tmdbMainUrl') . '/search/person?query=' . $name . '&include_adult=false&language=' . $language;

        $response = $this->client->request('GET', $urlToSeek, [
            'headers' => [
                'Authorization' => $this->getParameter('tmdbAccessKey'),
                'accept' => 'application/json',
            ],
        ]);

        $jsonRaw = json_decode($response->getContent(), true);

        return $jsonRaw;
    }
    public function GetPersonById(int $seekId)
    {
        $urlToSeek = $this->getParameter('tmdbMainUrl') . '/person/' . $seekId . '?&language=fr-FR';

        $response = $this->client->request('GET',  $urlToSeek, [
            'headers' => [
                'Authorization' => $this->getParameter('tmdbAccessKey'),
                'accept' => 'application/json',
            ],
        ]);

        $jsonRaw = json_decode($response->getContent(), true);

        return $jsonRaw;
    }
public function GetSocialMediaById(int $seekId){
    $urlToSeek = $this->getParameter('tmdbMainUrl') . '/person/' . $seekId . '/external_ids';

    $response = $this->client->request('GET', $urlToSeek, [
        'headers' => [
            'Authorization' => $this->getParameter('tmdbAccessKey'),
            'accept' => 'application/json',
        ],
      ]);

      $jsonRaw = json_decode($response->getContent(), true);

      return $jsonRaw;
}
}

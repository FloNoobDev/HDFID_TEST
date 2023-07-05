<?php

namespace App\Controller;

use App\Form\MoviesType;
use App\Form\ClearSessionType;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FilmsController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
        private RequestStack $requestStack,
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

    #[Route('/', name: 'films')]
    public function index(Request $request): Response
    {
        $clearSessionForm = $this->createForm(ClearSessionType::class);
        $clearSessionForm->handleRequest($request);

        $moviesForm = $this->createForm(MoviesType::class);
        
        $moviesForm->handleRequest($request);
        
        $session = $this->requestStack->getSession();
        
        if ($clearSessionForm->isSubmitted() && $clearSessionForm->isValid()) {
            $session->clear();
        }
        
        if ($session->get('title')) {
            $movies = $this->GetResultsByName($session->get('title'), $session->get('language'));
        }
        else{
            $movies = $this->GetPopularMovies();
            $clearSessionForm=null;
        }

        if ($moviesForm->isSubmitted() && $moviesForm->isValid()) {
            $formData = $moviesForm->getData();

            if ($formData['honeypot']) {
                $this->redirectToRoute('index');
            }

            $session->set('title', $formData['title']);
            $session->set('language', $formData['language']);

            $movies = $this->GetResultsByName($formData['title'], $formData['language']);

            $clearSessionForm = $this->createForm(ClearSessionType::class);
            $clearSessionForm->handleRequest($request);
        }

        return $this->render('films/index.html.twig', [
            'moviesForm' => $moviesForm->createView(),
            'clearSessionForm' => $clearSessionForm?$clearSessionForm->createView():null,
            'movies' => $movies,
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Component\HttpKernel\Attribute\Cache;
use App\CustomClass\GenericClass;
use App\Form\MoviesType;
use App\Form\ClearSessionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FilmsController extends GenericClass
{
    #[Cache(expires: 'tomorrow', public: true)]
    #[Route('/films', name: 'films')]
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
            $movies = $this->GetResultsByName($session->get('title'), $session->get('languageMovie'));
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
            $session->set('languageMovie', $formData['language']);

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
<?php

namespace App\Controller;

use Symfony\Component\HttpKernel\Attribute\Cache;
use App\CustomClass\GenericClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmDetailedController extends GenericClass
{
    #[Cache(expires: 'tomorrow', public: true)]
    #[Route('/film/{vid}', name: 'film')]
    public function index(int $vid): Response
    {
        $session = $this->requestStack->getSession();
        $language = $session->get('languageMovie') ? '&language='. $session->get('languageMovie') : null;

        $movie = $this->GetResultForId($vid,$language);

        return $this->render('film_detailed/index.html.twig', [
            'movie' => $movie,
        ]);
    }
}

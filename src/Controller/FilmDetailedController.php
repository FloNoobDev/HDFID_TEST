<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmDetailedController extends AbstractController
{
    #[Route('/film/detailed', name: 'app_film_detailed')]
    public function index(): Response
    {
        return $this->render('film_detailed/index.html.twig', [
            'controller_name' => 'FilmDetailedController',
        ]);
    }
}

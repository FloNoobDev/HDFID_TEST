<?php

namespace App\Controller;

use App\CustomClass\GenericClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends GenericClass
{
    #[Route('/person/{vid}', name: 'person')]
    public function index(int $vid): Response
    {
        $person = $this->GetPersonById($vid);
        $linkImdb = $this->GetSocialMediaById($vid)['imdb_id'] ? 'https://www.imdb.com/name/' . $this->GetSocialMediaById($vid)['imdb_id'] : null;
        $linkFacebook = $this->GetSocialMediaById($vid)['facebook_id']? 'https://www.facebook.com/' .$this->GetSocialMediaById($vid)['facebook_id'] : null;

        return $this->render('person/index.html.twig', [
            'person' => $person,
            'imdb' => $linkImdb,
            'facebook' => $linkFacebook,
        ]);
    }
}

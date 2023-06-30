<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class tmdbService
{
  
 function getGenres(){     
     $client = new \GuzzleHttp\Client();
     
     $response = $client->request('GET', 'https://api.themoviedb.org/3/genre/movie/list?language=en', [
         'headers' => [
             'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyM2RiMmZhMmZiMWNiM2YwYTFmNDJlN2NjNTQ4YmU4MCIsInN1YiI6IjVjY2JlZjI1OTI1MTQxMDQ1ZDI2YzkyNCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.Up9sJcfYAEahEK-NH8fyPbNr9q801QQrQI29qS27r2o',
             'accept' => 'application/json',
            ],
        ]);
        
        echo $response->getBody();
    }

   function getDetail(){
$client = new \GuzzleHttp\Client();

$response = $client->request('GET', 'https://api.themoviedb.org/3/movie/movie_id?language=en-US', [
  'headers' => [
    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyM2RiMmZhMmZiMWNiM2YwYTFmNDJlN2NjNTQ4YmU4MCIsInN1YiI6IjVjY2JlZjI1OTI1MTQxMDQ1ZDI2YzkyNCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.Up9sJcfYAEahEK-NH8fyPbNr9q801QQrQI29qS27r2o',
    'accept' => 'application/json',
  ],
]);

echo $response->getBody();
   } 
    
}
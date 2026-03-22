<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class CityWeatherController extends AbstractController
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/api/weather', name: 'api_weather', methods: ['GET'])]
    public function getWeather(Request $request, ParameterBagInterface $params)
    {
      
        $city = $request->query->get('city');

        if (!$city) {
            return new JsonResponse(['message' => 'City parameter is required'], 400);
        }

        $apiKey = $params->get('api.super.key');

        $response = $this->client->request(
            'GET',
            "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}"
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode !== 200) {
            if ($statusCode === 404) {
                return new JsonResponse(['message' => 'City not found'], 400);
            }
            return new JsonResponse(['message' => 'API error'], $statusCode);
        }

        $content = $response->toArray();

        $result = [
            "city" =>  $content["name"],
            "temperature" => $content["main"]['temp'],
            "feels_like" => $content["main"]['feels_like'],
            "humidity" => $content['main']["humidity"],
            "description" => $content['weather'][0]['description']
        ];

        return new JsonResponse($result);
    }
}

//
//https://api.openweathermap.org/data/2.5/weather?q={cityName}&appid={APIKey}
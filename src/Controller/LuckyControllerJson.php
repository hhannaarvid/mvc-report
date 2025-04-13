<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson
{
    #[Route("/api")]
    public function view(): Response
    {

        $jsonroutes = [
            '/api' => 'view of all json routes',
            '/api/quote' => 'Quote of the day',
        ];

        $response = new JsonResponse($jsonroutes);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;

    }

    #[Route("/api/quote")]
    public function jsonNumber(): Response
    {
        $number = random_int(1, 5);
        date_default_timezone_set("Europe/Stockholm");
        $date = date("Y-m-d H:i:s");

        $quote = [
            1 => 'Köper man en stor creme fraiche till tacon så räcker den till mer än en liten förpackning.',
            2 => 'Jag är klar med min personliga utveckling men ni andra kan gärna fortsätta ett tag till. ',
            3 => 'När livet går åt skogen, börja räkna kantareller.',
            4 => 'Jag vill vara snäll men alla irriterar mig',
            5 => 'Sommaren är kort, men våren också. Även hösten. Och vintern, även om ingen vill erkänna det.'
        ];

        $data = [
            'quote' => $quote[$number],
            'date' => $date
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;

    }
}

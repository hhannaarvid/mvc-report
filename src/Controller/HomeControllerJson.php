<?php

namespace App\Controller;

use App\Card\PrettyDeck;
use App\Card\CardHand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeControllerJson extends AbstractController
{
    // #[Route("/api", name: "api_json")]
    // public function view(
    // ): Response
    // {
    //     $jsonroutes = [
    //         '/api' => 'view of all json routes',
    //         '/api/quote' => 'Quote of the day',
    //     ];

    //     $response = new JsonResponse($jsonroutes);
    //     $response->setEncodingOptions(
    //         $response->getEncodingOptions() | JSON_PRETTY_PRINT
    //     );
    //     return $response;
    // }

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

    #[Route("/api/deck")]
    public function deck(
        SessionInterface $session
    ): Response {
        //hämta objekt från session
        $deck = $session->get("deckObj2");
        $nice = $deck->cardsArray();

        $response = new JsonResponse($nice);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;

    }

    #[Route("/api/deck/shuffle")]
    public function deck_shuffle(
        SessionInterface $session
    ): Response {
        //hämta objekt från session
        $deck = $session->get("deckObj2");

        $deck->shuffle();

        $nice = $deck->cardsArray();

        $session->set("deckObj2", $deck);

        $response = new JsonResponse($nice);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw", name: "api_deck_draw", methods: ['GET'])]
    public function api_draw(
        SessionInterface $session
    ): Response {
        //hämta objekt från session
        $deck = $session->get("deckObj2");

        if (!$session->get('cardnumber')) {
            $cardnumber = 1;
        } else {
            //hämta antal kort från session
            $cardnumber = $session->get('cardnumber');
        }


        $cardhand = new Cardhand();
        for ($i = 0; $i < $cardnumber; $i++) {
            $onecard = $deck->draw();
            $cardhand->add($onecard);
        }

        $cardsLeft = $deck->cardsCount();

        $cardhandArr = $cardhand->cardsArray();
        $cardData = [
            'drawnCards' => $cardhandArr,
            'cardsLeft' => $cardsLeft
        ];

        $response = new JsonResponse($cardData);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api", name: "api", methods: ['GET'])]
    public function api(
        Request $request,
        SessionInterface $session
    ): Response {
        //skapa kortlek-objekt
        // $deck = new PrettyDeck();

        if (!$session->get('deckObj2')) {
            $deck = new PrettyDeck();
        } else {
            $deck = $session->get('deckObj2');
        }


        //spara i session
        $session->set("deckObj2", $deck);

        return $this->render('api.html.twig');
    }

    #[Route("/api", name: "api_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {
        //hämta data från formuläret
        $cardnumber = $request->request->get('num_cards');

        // Deal with the submitted form
        $session->set('cardnumber', $cardnumber);

        return $this->redirectToRoute('api_deck_draw');
    }
}

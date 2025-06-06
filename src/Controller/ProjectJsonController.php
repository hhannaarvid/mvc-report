<?php

namespace App\Controller;

namespace App\Controller;


use App\Card\ProjHelp;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;


class ProjectJsonController extends AbstractController
{
    #[Route('/api/proj', name: 'api_proj')]
    public function apiProj(
        SessionInterface $session
    ): Response {
        

        $data = [
            "antal spelare" => $session->get('players'),
            "användare 1" => $session->get('user_one'),
            "användare 2" => $session->get('user_two'),
            "användare 3" => $session->get('user_three'),
            "senaste poäng spelare 1" => $session->get('user_one_points'),
            "senaste poäng spelare 2" => $session->get('user_two_points'),
            "senaste poäng spelare 3" => $session->get('user_three_points')

        ];

        return $this->json($data);
    }

    #[Route('/api/proj/money', name: 'api_money')]
    public function apiMoney(
        SessionInterface $session
    ): Response {
        $userOne = $session->get("user_one");
        $userTwo = $session->get("user_two");
        $userThree = $session->get("user_three");

        $onemoney = 0;
        $twomoney = 0;
        $threemoney = 0;

        if ($userOne != null) {
            $onemoney = $session->get('one_money');
        }
        if ($userTwo != null) {
            $twomoney = $session->get('two_money');

        }
        if ($userThree != null) {
            $threemoney = $session->get('three_money');

        }
        $data = [
            "player1-money" => (int) $onemoney,
            "player2-money" => (int) $twomoney,
            "player3-money" => (int) $threemoney
        ];

        return $this->json($data);
    }

    #[Route('/api/proj/{player}', name: 'api_player')]
    public function apiPlayer(
        SessionInterface $session,
        int $player
    ): Response {
        if ($player === 1) {
            $data = [
                "Spelare" => $session->get('user_one'),
                "senaste poäng spelare 1" => $session->get('user_one_points'),
                "spelad korthand" => $session->get('user1'),
                "Insättning/vinst" => $session->get('one_money') 

            ];
        }
        if ($player === 2) {
            $data = [
                "Spelare" => $session->get('user_two'),
                "senaste poäng spelare 2" => $session->get('user_two_points'),
                "spelad korthand" => $session->get('user2'),
                "Insättning/vinst" => $session->get('two_money') 

            ];
        }
        if ($player === 3) {
            $data = [
                "Spelare" => $session->get('user_three'),
                "senaste poäng spelare 1" => $session->get('user_three_points'),
                "spelad korthand" => $session->get('user3'),
                "Insättning/vinst" => $session->get('three_money') 

            ];
        }
        return $this->json($data);
    }

    #[Route("/api/start", name: "api_start", methods: ['POST'])]
    public function apiStart(
        Request $request,
        SessionInterface $session
    ): Response {
        //hämta data från formuläret
        $players = $request->request->get('start');

        // Deal with the submitted form
        $session->set('playersapi', $players);

        return $this->redirectToRoute('api_start_draw');
    }

    #[Route("/api/start/draw", name: "api_start_draw")]
    public function apiStartDraw(
        SessionInterface $session,
    ): Response {
        $helper = new ProjHelp();
        $player = $session->get('playersapi');

        $helper->startDraws($session, (int) $player);
        $startData = [
            'Player1' => $session->get('user1'),
            'Player2' => $session->get('user2'),
            'Player3' => $session->get('user3'),
            'Bank' => $session->get('bankhand')
        ];

        $response = new JsonResponse($startData);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/proj/gamedeck', name: 'game_deck')]
    public function gameDeck(
        SessionInterface $session
    ): Response {
        $deck = $session->get('gameDeck');
        $deckArr = $deck->cardsArray();

        $data = [
            "Aktuell kortlek" => $deckArr
        ];

        return $this->json($data);
    }

}

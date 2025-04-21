<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\Card;
use App\Card\DeckOfCard;
use App\Card\CardHand;

class GameController extends AbstractController
{
    // startsida för kortspel
    #[Route("/game", name: "game")]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {
        // //skapa ny kortlek
        // $deck = new DeckOfCard();

        // //gör till array
        // $deckArr = $deck->cardsArray();

        // //spara i sessionen
        // $session->set("deckArr", $deckArr);
        // $session->set("deckObj", $deck);


        // $cards = new Card('2', '♥'); // test?

        // $data = [
        //     "cardnumber" => $cards->getCardString()
        // ];
        return $this->render('game/game.html.twig');
    }

    #[Route("/game/init", name: "gameInit")] 
        public function gameInit(
            SessionInterface $session
        ): Response {

            return $this->render('game/game_init.html.twig');
        
    }
}
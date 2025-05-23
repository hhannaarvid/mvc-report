<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\Card;
use App\Card\DeckOfCard;
use App\Card\CardHand;

class CardController extends AbstractController
{
    // samlingssida med lista över alla routes som har med card att göra
    #[Route("/card", name: "card")]
    public function initCallback(
        SessionInterface $session
    ): Response {
        //skapa ny kortlek
        $deck = new DeckOfCard();

        //gör till array
        $deckArr = $deck->cardsArray();

        //spara i sessionen
        $session->set("deckArr", $deckArr);
        $session->set("deckObj", $deck);


        $cards = new Card('2', '♥'); // test?

        $data = [
            "cardnumber" => $cards->getCardString()
        ];
        return $this->render('card/card.html.twig', $data);
    }

    #[Route("/card/deck", name: "cardDeck")]
    // visar hela kortleken
    public function cardDeck(
        SessionInterface $session
    ): Response {
        //hämta från session
        $deckArr = $session->get("deckArr");


        $data = [
            "deck" => $deckArr
        ];

        return $this->render('card/cardDeck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "cardDeckShuffle")]
    // blanda kortleken
    public function shuffleDeck(
        SessionInterface $session
    ): Response {
        // hämta från session
        $deck = $session->get("deckObj");

        //blanda
        // shuffle($deckArr);
        $deck->shuffle();

        $deckArr = $deck->cardsArray();

        //spara i sessionen
        $session->set("deckObj", $deck);

        $data = [
            "shuffled" => $deckArr
        ];

        return $this->render('card/cardDeckShuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "cardDeckDraw")]
    // visar hela kortleken
    public function cardDeckDraw(
        SessionInterface $session
    ): Response {
        //hämta objekt från session
        $deck = $session->get("deckObj");

        //dra ett kort
        $draw = $deck->draw();
        // $draw = array_shift($deck);

        //gör till sträng
        $drawStr = $draw->getCardString();
        // var_dump($draw);

        //antal kvar i kortleken
        $count = $deck->cardsCount();

        //gör till array
        // $deckArr = $deck->cardsArray();


        $data = [
            "deck" => $deck,
            "draw" => $drawStr,
            "count" => $count
        ];

        return $this->render('card/cardDeckDraw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "cardDeckDrawNum")]
    // visar hela kortleken
    public function cardDeckDrawNum(
        SessionInterface $session,
        int $num
    ): Response {
        //hämta objekt från session
        $deck = $session->get("deckObj");

        //dra kort och skapa objekt i cardhand
        $cardhand = new Cardhand();
        for ($i = 0; $i < $num; $i++) {
            $onecard = $deck->draw();
            $cardhand->add($onecard);
        }

        //antal kvar i kortleken
        $count = $deck->cardsCount();

        //gör till array
        $deckArr = $cardhand->cardsArray();
        // var_dump(gettype($deckArr));

        //spara array i session
        // $session->set('deck', $deck);


        $data = [
            "deck" => $deck,
            "drawHand" => $deckArr,
            "count" => $count
        ];

        return $this->render('card/cardDeckDraw2.html.twig', $data);
    }

    //SESSION ROUTES ------------------------------------------- //
    // öppna session och printa allt som finns där i
    #[Route("/session", name: "session")]
    public function session(
        SessionInterface $session
    ): Response {

        $data = [
            'sessionData' => $session->all()
        ];

        return $this->render('card/session.html.twig', $data);
    }

    // ta bort allt i sessionen!
    #[Route("/session/delete", name: "session_delete")]
    public function sessionDelete(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash(
            'delete',
            'Session was deleted.'
        );

        return $this->redirectToRoute('session');
    }

}

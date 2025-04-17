<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\Card;
use App\Card\DeckOfCard;



class CardController extends AbstractController {
    // samlingssida med lista över alla routes som har med card att göra
    #[Route("/card", name: "card")]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $cards = new Card('2','♥');

        $data = [
            "cardnumber" => $cards->getAsString()
        ];
        return $this->render('card/card.html.twig', $data);
    }

    #[Route("/card/deck", name: "card_deck")]
    // visar hela kortleken
    // starta session?
    public function card_deck(
        SessionInterface $session
    ): Response
    {
        $deck = new DeckOfCard();

        $session->set("deck", $deck);

        $deckArr = $deck->cardsArray();

        $session->set("deckArr", $deckArr);

        $data = [
            "deck" => $deckArr
        ]; 

        // var_dump($cards);

        return $this->render('card/card_deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_deck_suffle")]
    // blanda kortleken
    // starta session?
    public function suffle_deck(): Response
    {
        $deck = new DeckOfCard(); //object

        $shuffled = $deck->shuffleDeck();

        $data = [
            "shuffled" => $shuffled
        ]; 

        return $this->render('card/card_deck_shuffle.html.twig', $data);
    }



    //SESSION ROUTES ------------------------------------------- //
    // öppna session och printa allt som finns där i
    #[Route("/session", name: "session")]
    public function session(
        SessionInterface $session
    ): Response
    {

        $data = [
            'sessionData' => $session->all()
        ];

        return $this->render('card/session.html.twig', $data);
    }

    // ta bort allt i sessionen!
    #[Route("/session/delete", name: "session_delete")]
    public function session_delete(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash(
            'delete',
            'Session was deleted.'
        );

        return $this->redirectToRoute('session');
    }

}


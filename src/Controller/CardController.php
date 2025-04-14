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
    public function card(): Response
    {
        $cards = new Card();

        $data = [
            "cardnumber" => $cards->getcard()
        ];
        return $this->render('card/card.html.twig', $data);
    }

    #[Route("/card/deck", name: "card_deck")]
    public function card_deck(): Response
    {
        $deck = new DeckOfCard();

        $data = [
            "cardnumber" => $deck->getdeck()
        ];
        return $this->render('card/card.html.twig', $data);
    }





    //SESSION ROUTES ------------------------------------------- //
    // öppna session och printa allt som finns där i
    #[Route("/session", name: "session")]
    public function initCallback(
        Request $request,
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


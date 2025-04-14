<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\Card;


class CardController extends AbstractController {
    // ett kort
    #[Route("/card", name: "card")]
    public function card(): Response
    {
        $cards = new Card();

        $data = [
            "cardnumber" => $cards->getcard()
        ];
        return $this->render('card/card.html.twig', $data);
    }

}

// class CardHand {
//     // en hand av kort
// }

// class DeckOfCards {
//     // en kortlek
// }
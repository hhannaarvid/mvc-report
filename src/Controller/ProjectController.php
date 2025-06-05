<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\DeckOfCard;
use App\Card\GameHelp;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProjectController extends AbstractController
{
    // STARTSIDA FÖR SPELET #################################
    #[Route("/proj", name: "proj")]
    public function home(): Response
    {
        return $this->render('project/proj.html.twig');
    }


    // INFORMATION OM PROJEKT #################################
    #[Route("/proj/about", name: "proj_about")]
    public function homeAbout(): Response
    {
        return $this->render('project/proj_about.html.twig');
    }


    // SPARA NAMN #################################
    #[Route("/name_post", name: "name_post", methods: ['POST'])]
    public function saveName(Request $request, SessionInterface $session): RedirectResponse
    {
        $userOne = $request->request->get('user-one');
        $userTwo = $request->request->get('user-two');
        $userThree = $request->request->get('user-three');
        $players = 0;

        if ($userOne) {
            $session->set('user_one', $userOne);
            $session->set('user_one_points', 0);
            $players += 1;
        }

        if ($userTwo) {
            $session->set('user_two', $userTwo);
            $session->set('user_two_points', 0);
            $players += 1;
        }

        if ($userThree) {
            $session->set('user_three', $userThree);
            $session->set('user_three_points', 0);
            $players += 1;
        }

        $session->set('players', $players);

        return $this->redirectToRoute('projInit');
    }


    // INITIERA SPELET #################################
    #[Route("/proj/init", name: "projInit")]
    public function gameInit(
        SessionInterface $session
    ): Response {

        $helper = new GameHelp();
        $helper->startGame($session);

        $data = [
            "userpoints" => $session->get("userpoints"),
            "bankpoints" => $session->get("bankpoints"),
            "cardhand" => $session->get("cardhand"),
            "userOne" => $session->get("user_one"),
            "bankhand" => $session->get("bankhand"),
            "user1" => $session->get("user1")
        ];

        return $this->render('project/proj_init.html.twig', $data);
        // return $this->redirectToRoute('proj_play');
    }


    // DRA ETT KORT FÖR ALLA #################################
    #[Route("/proj/play", name: "proj_play", methods: ["GET"])]
    public function playGet(): Response
    {
        return $this->render("proj/proj_play.html.twig");
    }


    // DRA STARTKORT FÖR ALLA #################################
    #[Route("/proj/play", name: "proj_play", methods: ['POST'])]
    public function playPost(
        SessionInterface $session
    ): Response {
        $helper = new GameHelp();
        $players = $session->get('players');

        //startkort
        $helper->startDraws($session, $players); 

        //poäng för banken
        $bankhand = $session->get("bankhand");
        $bankpoints = $helper->countPoints($bankhand);
        $session->set("bankpoints", $bankpoints);

        //poäng för spelare 1
        $user1 = $session->get("user1");
        $userOnePoints = $session->get("user_one_points");
        $userOnePoints = $helper->countPoints($user1);
        $session->set("user_one_points", $userOnePoints);

        if ($session->has('user_two')) {
            $user2 = $session->get("user2");
            $userTwoPoints = $session->get("user_two_points");
            $userTwoPoints = $helper->countPoints($user2);
            $session->set("user_two_points", $userTwoPoints);
        }

        if ($session->has('user_three')) {
            $user3 = $session->get("user3");
            $userThreePoints = $session->get("user_three_points");
            $userThreePoints = $helper->countPoints($user3);
            $session->set("user_three_points", $userThreePoints);
        }

        $data = [
            "bankpoints" => $bankpoints,
            "cardhand" => $session->get("cardhand"), //new
            "user1" => $user1, //new
            "user2" => $session->get("user2"), //new
            "user3" => $session->get("user3"), //new
            "userOne" => $session->get("user_one"),
            "userTwo" => $session->get("user_two"),
            "userThree" => $session->get("user_three"),
            "bankhand" => $bankhand,
            "userOnePoints" => $session->get("user_one_points"),
            "userTwoPoints" => $session->get("user_two_points"),
            "userThreePoints" => $session->get("user_three_points")
        ];

        return $this->render('project/proj_play.html.twig', $data);
    }


    // DRA ETT KORT FÖR SPELARE 1 ##################################
    #[Route("/proj/play1", name: "play1", methods: ["GET"])]
    public function play1Get(): Response
    {
        return $this->render("proj/proj_play_view.html.twig");
    }

    #[Route("proj/play1", name: "play1", methods: ['POST'])]
    public function play1(
        SessionInterface $session
    ): Response {
        //hämta korthand för spelare 1
        $user1 = $session->get("user1");
        $deck = $session->get('gameDeck');

        //dra ett nytt kort för spelare 1
        $draw = $deck->draw();

        //spara draget kort i korthand
        $user1[] = $draw->getCardString();

        //spara ny korthand i session
        $session->set("user1", $user1);

        //spara kortleken igen
        $session->set('gameDeck', $deck);

        //redirect till proj_play
        return $this->redirectToRoute('proj_play_view');

    }
    // ######################################################


    // DRA ETT KORT FÖR SPELARE 1 ##################################
    #[Route("/proj/play2", name: "play2", methods: ["GET"])]
    public function play2Get(): Response
    {
        return $this->render("proj/proj_play_view.html.twig");
    }
    
    #[Route("proj/play2", name: "play2", methods: ['POST'])]
    public function play2(
        SessionInterface $session
    ): Response {
        //hämta korthand för spelare 2
        $user2 = $session->get("user2");
        $deck = $session->get('gameDeck');

        //dra ett nytt kort för spelare 2
        $draw = $deck->draw();

        //spara draget kort i korthand
        $user2[] = $draw->getCardString();

        //spara ny korthand i session
        $session->set("user2", $user2);

        //spara kortleken igen
        $session->set('gameDeck', $deck);

        //redirect till proj_play
        return $this->redirectToRoute('proj_play_view');

    }
    // ######################################################

    // DRA ETT KORT FÖR SPELARE 1 ##################################
    #[Route("/proj/play3", name: "play3", methods: ["GET"])]
    public function play3Get(): Response
    {
        return $this->render("proj/proj_play_view.html.twig");
    }
    
    #[Route("proj/play3", name: "play3", methods: ['POST'])]
    public function play3(
        SessionInterface $session
    ): Response {
        //hämta korthand för spelare 3
        $user2 = $session->get("user3");
        $deck = $session->get('gameDeck');

        //dra ett nytt kort för spelare 3
        $draw = $deck->draw();

        //spara draget kort i korthand
        $user2[] = $draw->getCardString();

        //spara ny korthand i session
        $session->set("user3", $user2);

        //spara kortleken igen
        $session->set('gameDeck', $deck);

        //redirect till proj_play
        return $this->redirectToRoute('proj_play_view');

    }
    // ######################################################


    // VISA ALLAS HÄNDER IGEN #################################
    #[Route("/proj/play_view", name: "proj_play_view", methods: ['GET'])]
    public function playView(
        SessionInterface $session
    ): Response {
        // nytt
        $helper = new GameHelp();

        //poäng för banken
        $bankhand = $session->get("bankhand");
        $bankpoints = $helper->countPoints($bankhand);
        $session->set("bankpoints", $bankpoints);

        //poäng för spelare 1
        $user1 = $session->get("user1");
        $userOnePoints = $session->get("user_one_points");
        $userOnePoints = $helper->countPoints($user1);
        $session->set("user_one_points", $userOnePoints);

        if ($session->has('user_two')) {
            $user2 = $session->get("user2");
            $userTwoPoints = $session->get("user_two_points");
            $userTwoPoints = $helper->countPoints($user2);
            $session->set("user_two_points", $userTwoPoints);
        }

        if ($session->has('user_three')) {
            $user3 = $session->get("user3");
            $userThreePoints = $session->get("user_three_points");
            $userThreePoints = $helper->countPoints($user3);
            $session->set("user_three_points", $userThreePoints);
        }
        // nytt

        $data = [
            "bankpoints" => $bankpoints, //new
            "cardhand" => $session->get("cardhand"), 
            "user1" => $user1, //new
            "user2" => $session->get("user2"), //new
            "user3" => $session->get("user3"), //new
            "userOne" => $session->get("user_one"),
            "userTwo" => $session->get("user_two"),
            "userThree" => $session->get("user_three"),
            "bankhand" => $session->get("bankhand"),
            "userOnePoints" => $session->get("user_one_points"), //new
            "userTwoPoints" => $session->get("user_two_points"), //new
            "userThreePoints" => $session->get("user_three_points") //new
        ];

        return $this->render('project/proj_play_view.html.twig', $data);
    }



    #[Route("/proj/save", name: "save_bank", methods: ['POST'])]
    public function save(
        SessionInterface $session
    ): Response {
        $helper = new GameHelp();

        $helper->bank2($session);

        $bankpoints = $session->get("bankpoints");

        while ($bankpoints <= 16) {
            $helper->bank2($session);
            $bankpoints = $session->get("bankpoints");
        }

        $data = [
            "bankpoints" => $session->get("bankpoints"), //new
            "cardhand" => $session->get("cardhand"), 
            "user1" => $session->get("user1"), //new
            "user2" => $session->get("user2"), //new
            "user3" => $session->get("user3"), //new
            "userOne" => $session->get("user_one"),
            "userTwo" => $session->get("user_two"),
            "userThree" => $session->get("user_three"),
            "bankhand" => $session->get("bankhand"),
            "userOnePoints" => $session->get("user_one_points"), //new
            "userTwoPoints" => $session->get("user_two_points"), //new
            "userThreePoints" => $session->get("user_three_points") //new
        ];

        return $this->render('project/proj_bank.html.twig', $data);
    }

    #[Route("/proj/score", name: "proj_score", methods: ['POST'])]
    public function score(
        SessionInterface $session
    ): Response {

        $helper = new GameHelp();
        $bankpoints = $session->get('bankpoints');
        $userOnePoints = $session->get('user_one_points');
        $userTwoPoints = $session->get('user_two_points');
        $userThreePoints = $session->get('user_three_points');
        $userOne = $session->get("user_one");
        $userTwo = $session->get("user_two");
        $userThree = $session->get("user_three");

        $message1 = $helper->score2($userOnePoints, $bankpoints, $userOne);
        $message2 = $helper->score2($userTwoPoints, $bankpoints, $userTwo);
        $message3 = $helper->score2($userThreePoints, $bankpoints, $userThree);

        

        $data = [
            "message1" => $message1,
            "message2" => $message2,
            "message3" => $message3,
            "userOne" => $session->get("user_one"),
            "userTwo" => $session->get("user_two"),
            "userThree" => $session->get("user_three"),
            "userOnePoints" => $session->get("user_one_points"), //new
            "userTwoPoints" => $session->get("user_two_points"), //new
            "userThreePoints" => $session->get("user_three_points"), //new
            "bankpoints" => $session->get("bankpoints"),
            "user1" => $session->get("user1"), //new
            "user2" => $session->get("user2"), //new
            "user3" => $session->get("user3")
        ];

        return $this->render('project/proj_score.html.twig', $data);
    }
}

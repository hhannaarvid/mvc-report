<?php

namespace App\Controller;

use App\Card\ProjHelp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectResultController extends AbstractController
{
    #[Route("/proj/save", name: "save_bank", methods: ['POST'])]
    public function save(
        SessionInterface $session
    ): Response {
        $helper = new ProjHelp();

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

        $helper = new ProjHelp();
        $bankpoints = $session->get('bankpoints');
        $userOnePoints = $session->get('user_one_points');
        $userTwoPoints = $session->get('user_two_points');
        $userThreePoints = $session->get('user_three_points');
        $userOne = $session->get("user_one");
        $userTwo = $session->get("user_two");
        $userThree = $session->get("user_three");

        $message1 = "";
        $message2 = "";
        $message3 = "";

        $winnings1 = 0;
        $winnings2 = 0;
        $winnings3 = 0;

        //total bank
        $oneMoney = $session->get('one_money');
        $twoMoney = $session->get('two_money');
        $threeMoney = $session->get('three_money');
        if ($userOne != null) {
            $message1 = $helper->score2($userOnePoints, $bankpoints, $userOne);
            $win1 = $helper->score3($userOnePoints, $bankpoints);
            $winnings1 = $helper->winnings($userOnePoints, $win1);
            $session->set('onetotal', $session->get('onetotal') + ($oneMoney * $winnings1));
        }
        if ($userTwo != null) {
            $message2 = $helper->score2($userTwoPoints, $bankpoints, $userTwo);
            $win2 = $helper->score3($userTwoPoints, $bankpoints);
            $winnings2 = $helper->winnings($userTwoPoints, $win2);
            $session->set('twototal', $session->get('twoTotal') + ($twoMoney * $winnings2));
        }
        if ($userThree != null) {
            $message3 = $helper->score2($userThreePoints, $bankpoints, $userThree);
            $win3 = $helper->score3($userThreePoints, $bankpoints);
            $winnings3 = $helper->winnings($userThreePoints, $win3);
            $session->set('threetotal', $session->get('threeTotal') + ($threeMoney * $winnings3));
        }
        //total bank

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
            "user3" => $session->get("user3"),
            "winnings1" => $winnings1,
            "winnings2" => $winnings2,
            "winnings3" => $winnings3,
            "one_money" => $session->get('one_money'),
            "two_money" => $session->get('two_money'),
            "three_money" => $session->get('three_money')

        ];

        return $this->render('project/proj_score.html.twig', $data);
    }
}

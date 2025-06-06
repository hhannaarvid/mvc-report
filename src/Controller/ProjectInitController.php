<?php

namespace App\Controller;

use App\Card\GameHelp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectInitController extends AbstractController
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
        $oneMoney = $request->request->get('one-money');
        $twoMoney = $request->request->get('two-money');
        $threeMoney = $request->request->get('three-money');

        $players = 0;

        if ($userOne) {
            $session->set('user_one', $userOne);
            $session->set('user_one_points', 0);
            $session->set('one_money', $oneMoney);
            $session->set('onetotal', 0);
            $players += 1;
        }

        if ($userTwo) {
            $session->set('user_two', $userTwo);
            $session->set('user_two_points', 0);
            $session->set('two_money', $twoMoney);
            $session->set('twototal', 0);
            $players += 1;
        }

        if ($userThree) {
            $session->set('user_three', $userThree);
            $session->set('user_three_points', 0);
            $session->set('three_money', $threeMoney);
            $session->set('threetotal', 0);
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
}
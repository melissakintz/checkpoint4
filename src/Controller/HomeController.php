<?php

namespace App\Controller;

use App\Repository\CompilationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * @Route("/board", name="board")
     */
    public function board(CompilationRepository $repository): Response
    {
        $suggestions = $repository->findOther($this->getUser());
        $compilations = $repository->findBy(['creator' => $this->getUser()], [], 5);
        return $this->render('home/board.html.twig', [
            'suggestions' => $suggestions,
            'compilations' => $compilations
        ]);
    }
}

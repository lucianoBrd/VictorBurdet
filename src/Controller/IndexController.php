<?php

namespace App\Controller;

use App\Repository\WorkRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(WorkRepository $repo)
    {
        $works = $repo->findAll();
        return $this->render('index/index.html.twig', [
            'works' => $works
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\DataRepository;
use App\Repository\NewsRepository;
use App\Repository\WorkRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(WorkRepository $repo, DataRepository $repoData, NewsRepository $repoNews)
    {
        $works = $repo->findAll();
        $homes = $repoData->findHome(true);
        $news = $repoNews->findAll();
        return $this->render('index/index.html.twig', [
            'works' => $works,
            'homes' => $homes,
            'news' => $news
        ]);
    }
}

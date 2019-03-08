<?php

namespace App\Controller;

use App\Repository\DataRepository;
use App\Repository\NewsRepository;
use App\Repository\WorkRepository;
use App\Repository\AboutRepository;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(WorkRepository $repo, DataRepository $repoData, NewsRepository $repoNews, AboutRepository $repoABout, ContactRepository $repoContact)
    {
        $works = $repo->findAll();
        $homes = $repoData->findHome(true);
        $news = $repoNews->findAll();
        $about = $repoABout->find(1);
        $contact = $repoContact->find(1);
        return $this->render('index/index.html.twig', [
            'works' => $works,
            'homes' => $homes,
            'news' => $news,
            'about' => $about,
            'contact' => $contact
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, ContactRepository $repoContact)
    {
        $contact = $repoContact->find(1);
        $email = $request->request->get('subscribe-email');
        $name = $request->request->get('subscribe-name');
        $msg = $request->request->get('subscribe-message');

        $subject = 'Contact site Victor Burdet';

        $message = '<strong>Nom : </strong>'.$name.'<br/><br/>';

        $message .= '<strong>Email : </strong>'.$email.'<br/><br/>';

        $message .= $msg.'<br/>';

        $header="MIME-Version: 1.0\r\n";
        $header.='From:"LucienBrd"<no-reply@lucien-brd.com>'."\n";
        $header.='Content-Type:text/html; charset="uft-8"'."\n";
        $header.='Content-Transfer-Encoding: 8bit';

        
        if($email != null && $name != null && $msg != null){
            mail($contact->getEmail(),$subject,$message,$header);
        }
        
        return $this->redirectToRoute('index');
    }
}

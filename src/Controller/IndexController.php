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
    public function contact(Request $request, \Swift_Mailer $mailer, ContactRepository $repoContact)
    {
        $contact = $repoABout->find(1);
        $email = $request->query->get('subscribe-email');
        $name = $request->query->get('subscribe-name');
        $message = $request->query->get('subscribe-message');
        
        $mail = $contact->getEmail();
        $message = (new\ Swift_Message('Contacte site Victor Burdet')) 
            ->setFrom('no-reply@victorburdet.com') 
            ->setTo($mail) 
            ->setBody(
                $this->renderView('email/email.html.twig', [
                    'email' => $email,
                    'name' => $name,
                    'message' => $message
                ]),
                'text/html'
            );
        if($email != null && $name != null && $message != null){
            $mailer->send($message);
        }
        
        return $this->redirectToRoute('index');
    }
}

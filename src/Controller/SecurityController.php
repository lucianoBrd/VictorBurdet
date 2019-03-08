<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * @Route("/admin", name="security_login")
     */
    public function login(){

        return $this->render('security/index.html.twig');
    }

    /**
     * @Route("/admin/deconnexion", name="security_logout")
     */
    public function logout(){}
}

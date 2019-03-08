<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * @Route("/admin", name="security_login")
     */
    public function login(UserPasswordEncoderInterface $encoder, ObjectManager $manager){
        /*$user = new User();
        $user->setPassword('abc');
        $hash = $encoder->encodePassword($user, $user->getPassword());
        $user->setUsername("victor")
            ->setPassword($hash);
        $manager->persist($user);

        $manager->flush();*/
        return $this->render('security/index.html.twig');
    }

    /**
     * @Route("/admin/deconnexion", name="security_logout")
     */
    public function logout(){}
}

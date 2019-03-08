<?php

namespace App\Controller;

use App\Entity\About;
use App\Form\AboutType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAboutController extends AbstractController
{

    /**
     * @Route("/admin/about/{id}", name="admin_about")
     */
    public function manage(Request $request, ObjectManager $manager, About $about = null, Filesystem $fileSystem)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $name = $about->getData()->getName();

        $form = $this->createForm(AboutType::class, $about);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $noneChange = false;
            if($about->getData()->getName() == null){
                $about->getData()->setName($name);
                $noneChange = true;
            }

            if(!$noneChange){
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $about->getData()->getName();
                $fileSystem->remove($this->getParameter('about_directory').'/about.'.$about->getData()->getExtension());
                $fileName = 'about.'.$file->guessExtension();

                $about->getData()->setExtension($file->guessExtension());
                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('about_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $about->getData()->setName($fileName);
            }

            $manager->persist($about);
            $manager->flush();

            $this->addFlash('success', 'About modifié');

            return $this->redirectToRoute('admin_about', ['id'=>1]);
        }

        return $this->render('admin_about/manage.html.twig', [
            'form' => $form->createView(),
            'about' => $about
        ]);
    }
}

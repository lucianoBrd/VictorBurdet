<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;

class AdminContactController extends AbstractController
{
    /**
     * @Route("/admin/contact/{id}", name="admin_contact")
     */
    public function manage(Request $request, ObjectManager $manager, Contact $contact = null, Filesystem $fileSystem)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $name = $contact->getData()->getName();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $noneChange = false;
            if($contact->getData()->getName() == null){
                $contact->getData()->setName($name);
                $noneChange = true;
            }

            if(!$noneChange){
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $contact->getData()->getName();
                $fileSystem->remove($this->getParameter('contact_directory').'/contact.'.$contact->getData()->getExtension());
                $fileName = 'contact.'.$file->guessExtension();

                $contact->getData()->setExtension($file->guessExtension());
                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('contact_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $contact->getData()->setName($fileName);
            }

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash('success', 'Contact modifié');

            return $this->redirectToRoute('admin_contact', ['id'=>1]);
        }

        return $this->render('admin_contact/manage.html.twig', [
            'form' => $form->createView(),
            'contact' => $contact
        ]);
    }
}

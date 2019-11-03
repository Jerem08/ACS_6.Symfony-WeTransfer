<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Transfer;
use App\Form\TransferFormType;
use App\Repository\TransferRepository;
use ZipArchive;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;

class WetransferController extends AbstractController
{
    /**
     * @Route("/wetransfer", name="wetransfer")
     */

    public function wetransfer(Request $request, ObjectManager $manager, UploadedFile $file = null)
    {
        // INIT
        $task = new Transfer();
        $zip= new ZipArchive();

        // CREATE
        $form = $this->createForm(TransferFormType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

          // FILE
          $file = $task->getFile();
          $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'.'.$file->guessExtension();

          // ZIP
          $zipName = md5(uniqid());
          $zip->open('uploads/'.$zipName.'.zip', ZipArchive::CREATE |  ZipArchive::OVERWRITE);
          $zip->addFile($file, $fileName);
          $zip->close();

          // SAVE
          $task->setDataLink($zipName);
          $manager->persist($task);
          $manager->flush();

         }


        return $this->render('wetransfer/index.html.twig', [
          'form' => $form->createView(),
          'controller_name' => 'WetransferController',
        ]);
    }

    /**
    * @Route("/wetranfer/download/{nomFichier}", name="wedownload")
    */
    public function download($nomFichier)
    {

      // il faut vérifier que le fichier demander ce trouve
      // dans la base de donnée

      // PREPARE FILE
      $data  = 'uploads/'.$nomFichier.'.zip';
      $response = new BinaryFileResponse($data);
      $disposition = HeaderUtils::makeDisposition(
        HeaderUtils::DISPOSITION_ATTACHMENT,
        $nomFichier.'.zip'
      );

      // SEND FILE
      $response->headers->set('Content-Disposition', $disposition);
      $reponse = $response->send();

      return $this->render('wetransfer/sucess.html.twig',
            ['controller_name' => 'WetransferController']);
    }

}

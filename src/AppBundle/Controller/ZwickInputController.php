<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ZwickInput;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File as File;

/**
 * Lab1_pomiar controller.
 *
 * @Route("/zwick")
 */
class ZwickInputController extends Controller
{
    /**
     * Lists all Lab1_pomiar entities.
     *
     * @Route("/", name="zwick_input_list")
     * @Method("GET")
     */
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Route("/new", name="zwick_new")
     */
    public function newAction(Request $request) {
        $input = new ZwickInput();
//        $input->setUser($this->getUser());
        $form = $this->createForm('AppBundle\Form\ZwickInputType', $input);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded CSV file
            /** @var File\UploadedFile $file */
            $file = $input->getFile();

            // persist the $input variable
            $em = $this->getDoctrine()->getManager();
            $em->persist($input);
            $em->flush();

            $connection = $em->getConnection();
            $statement = $connection->prepare("LOAD DATA INFILE :filename into table zwick_input_data".
                " fields terminated by ','".
                " lines terminated by '\r\n'".
                " ignore 1 lines".
                " (test_time, distance_standard, load_measurement)".
                " set id_input = :idinput");
            $statement->bindValue('filename', $file->getRealPath());
            $statement->bindValue('idinput', $input->getId());
            $statement->execute();

            $filesystem = new Filesystem();
            $filesystem->remove($file->getRealPath());

            return $this->redirect($this->generateUrl('index'));
        }

        return $this->render('zwick/upload.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
<?php

namespace AppBundle\Controller;

use AppBundle\Calc\ZwickCalculations;
use AppBundle\Entity\Zwick;
use AppBundle\Entity\ZwickData;
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
class ZwickController extends Controller
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
        $input = new Zwick();
        $form = $this->createForm('AppBundle\Form\ZwickType', $input);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded CSV file
            /**
             * @var File\UploadedFile $file
             * @var File\UploadedFile $report
             */
            $file = $input->getFileTra();
            $report = $input->getFilePdf();

            //handle pdf file
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $report->move(
                $this->getParameter('pdf_directory'),
                $fileName
            );

            $em = $this->getDoctrine()->getManager();
            // TODO remove all existing entities
            $existing_output = $em->getRepository('AppBundle:Zwick')
                ->findAll();
            foreach($existing_output as $output) {
                $em->remove($output);
            }
            // persist input to get ID
            $em->persist($input);
            $em->flush();
            // quickly load data from file
            $connection = $em->getConnection();
            $statement = $connection->prepare("LOAD DATA INFILE :filename into table zwick_data".
                " fields terminated by ','".
                " lines terminated by '\r\n'".
                " ignore 1 lines".
                " (test_time, distance_standard, load_measurement)".
                " set id_input = :idinput");
            $statement->bindValue('filename', $file->getRealPath());
            $statement->bindValue('idinput', $input->getId());
            $statement->execute();
            //get zwick_data from database
            $data = $this->getDoctrine()
                ->getRepository(ZwickData::class)
                ->findBy(array('zwick' => $input->getId()));
            $input->setData($data);

            $filesystem = new Filesystem();
            $filesystem->remove($file->getRealPath());

            $this->reportAction($input);
//            return $this->redirect($this->generateUrl('index'));
            return $this->render('zwick/report.html.twig', array(
                'zwick' => $input,
                'zwick_data' => $input->getData(),
            ));
        }

        return $this->render('zwick/upload.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Calculates and displays an entity.
     *
     * @Route("/generate/{id}", name="zwick_generate")
     * @Method("GET")
     */
    public function reportAction(Zwick $input)
    {
        $em = $this->getDoctrine()->getManager();
        //TODO multi user, multi projects
//        $existing_output = $em->getRepository('AppBundle:Project')
//            ->findOneBy(array('user' => $this->getUser()))->getZwick();
//        if($existing_output) {
//            $em->remove($existing_output);
//            $em->flush();
//        }

        $zwick_calculations = new ZwickCalculations($input);
        $output_data = $zwick_calculations->calculateData();

        //TODO persist Zwick entity after changes
//        $output = $zwick_calculations->getZwick();
//        $em->persist($output);

        foreach($output_data as $item) {
            $em->persist($item);
        }
        $em->flush();


    }
}
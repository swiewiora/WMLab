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
 * Zwick task controller.
 *
 * @Route("/zwick")
 */
class ZwickController extends Controller
{
    /**
     * @Route("/new", name="zwick_new")
     */
    public function newAction(Request $request) {
        $input = new Zwick();
        // get materials and send them to form builder
        $projectId = $request->query->getInt('project');
        $em = $this->getDoctrine()->getManager();
        $materials = $em->getRepository('AppBundle:Material')
            ->findBy(array('project' => $projectId));
        $form = $this->createForm('AppBundle\Form\ZwickType', $input, array(
            'materials' => $materials ) );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
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

            // persist input to get ID
            $em->persist($input);
            $em->flush();
            // fast load data from file
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
            // get zwick_data from database
            $data = $this->getDoctrine()
                ->getRepository(ZwickData::class)
                ->findBy(array('zwick' => $input->getId()));
            $input->setData($data);

            $filesystem = new Filesystem();
            $filesystem->remove($file->getRealPath() );

            $this->reportAction($input);
            return $this->redirect($this->generateUrl('zwick_show', array('id' => $input->getId() ) ) );
        }

        return $this->render('zwick/new.html.twig', array(
            'form' => $form->createView(),
        ) );
    }

    /**
     * Calculates data and uploads to db.
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

    /**
     * Finds and displays a Lab1_pomiar entity.
     *
     * @Route("/{id}/show", name="zwick_show")
     * @Method("GET")
     */
    public function showAction(Request $request, Zwick $zwick)
    {
        //TODO delete form
//        $deleteForm = $this->createDeleteForm($zwick);

        $em = $this->getDoctrine()->getManager();
        $dataArray = $em->getRepository('AppBundle:ZwickData')->findBy(array('zwick' => $zwick->getId()));

        $queryBuilder = $em->getRepository('AppBundle:ZwickData')
            ->createQueryBuilder('zwick_data')
            ->where('zwick_data.zwick = :idinput')
            ->setParameter('idinput', $zwick->getId()
            );
        $query = $queryBuilder->getQuery();

        $paginator  = $this->get('knp_paginator');
        $data = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1) /*page number*/,
            $request->query->getInt('limit', 25) /*limit per page*/
        );

        return $this->render('zwick/report.html.twig', array(
            'zwick_data_page' => $data,
            'zwick_data' => $dataArray,
            'zwick' => $zwick,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Lab1_pomiar entity.
     *
     * @Route("/{id}/data", name="zwick_data")
     * @Method("GET")
     */
    public function renderDataAction(Request $request, Zwick $zwick)
    {
        //TODO delete form
//        $deleteForm = $this->createDeleteForm($zwick);

        $em = $this->getDoctrine()->getManager();
//        $dataArray = $em->getRepository('AppBundle:ZwickData')->findBy(array('zwick' => $zwick->getId()));
        $queryBuilder = $em->getRepository('AppBundle:ZwickData')
            ->createQueryBuilder('qb')->where(array('zwick' => $zwick->getId()));
        $query = $queryBuilder->getQuery();

        $paginator  = $this->get('knp_paginator');
        $data = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1) /*page number*/,
            $request->query->getInt('limit', 25) /*limit per page*/
        );

        return $this->render('zwick/report.html.twig', array(
            'zwick_data' => $data,
            'zwick' => $zwick,
//            'delete_form' => $deleteForm->createView(),
        ));
    }
}
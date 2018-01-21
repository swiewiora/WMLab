<?php

namespace AppBundle\Controller;

use AppBundle\Calc\ZwickCalculations;
use AppBundle\Entity\Zwick;
use AppBundle\Entity\ZwickData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File as File;

/**
 * Zwick task controller.
 * @Route("/zwick")
 * @Security("has_role('ROLE_USER')")
 */
class ZwickController extends Controller
{
  /**
   * @Route("/new", name="zwick_new")
   */
  public function newAction(Request $request)
  {
    $input = new Zwick();
    // get materials and send them to form builder
    $projectId = $request->query->getInt('project');
    $em = $this->getDoctrine()->getManager();
    $materials = $em->getRepository('AppBundle:Material')
        ->findBy(array('project' => $projectId));
    $form = $this->createForm(
        'AppBundle\Form\ZwickType',
        $input,
        array(
            'materials' => $materials,
        )
    );
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      //set default shape
      $input->setShape(true);
      // $file stores the uploaded CSV file
      /**
       * @var File\UploadedFile $file
       * @var File\UploadedFile $report
       */
      $file = $input->getFileTra();
      $report = $input->getFilePdf();
      //handle pdf and csv file
      $fileName = md5(uniqid()).'.'.$report->guessExtension();
      $report->move(
          $this->getParameter('pdf_directory'),
          $fileName
      );
      $input->setFilePdf($this->getParameter('pdf_directory').'/'.$fileName);
      $fileName = md5(uniqid()).'.'.$file->guessExtension();
      $file->move(
          $this->getParameter('csv_directory'),
          $fileName
      );
      $input->setFileTra($this->getParameter('csv_directory').'/'.$fileName);

      // persist input to get ID
      $em->persist($input);
      $em->flush();
      // fast load data from file
      $connection = $em->getConnection();
      $statement = $connection->prepare(
          "LOAD DATA INFILE :filename into table zwick_data".
          " fields terminated by ','".
          " lines terminated by '\r\n'".
          " ignore 1 lines".
          " (test_time, distance_standard, load_measurement)".
          " set id_input = :idinput"
      );
      $statement->bindValue('filename', $input->getFileTra());
      $statement->bindValue('idinput', $input->getId());
      $statement->execute();
      // get zwick_data from database
      $data = $this->getDoctrine()
          ->getRepository(ZwickData::class)
          ->findBy(array('zwick' => $input->getId()));
      $input->setData($data);

      $this->reportAction($input);

      return $this->redirect($this->generateUrl('zwick_show', array('id' => $input->getId())));
    }

    return $this->render(
        'zwick/new.html.twig',
        array(
            'form' => $form->createView(),
        )
    );
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

    $zwick_calculations = new ZwickCalculations($input);
    $output_data = $zwick_calculations->calculateData();

    foreach ($output_data as $item) {
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
    $deleteForm = $this->createDeleteForm($zwick);
    $em = $this->getDoctrine()->getManager();
    $dataArray = $em->getRepository('AppBundle:ZwickData')->findBy(array('zwick' => $zwick->getId()));
    $projectId = $zwick->getMaterial()->getProject()->getId();

    return $this->render(
        'zwick/report.html.twig',
        array(
            'zwick_data' => $dataArray,
            'zwick' => $zwick,
            'delete_form' => $deleteForm->createView(),
            'projectId' => $projectId,
        )
    );
  }

  /**
   * Deletes a Zwick entity.
   *
   * @Route("/{id}", name="zwick_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, Zwick $zwick)
  {
    $projectId = $zwick->getMaterial()->getProject()->getId();
    $form = $this->createDeleteForm($zwick);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($zwick);
      $em->flush();
    }

    return $this->redirectToRoute('project_show', array('id' => $projectId));
  }

  /**
   * Creates a form to delete a Zwick entity.
   *
   * @param Zwick $zwick The Zwick entity
   * @return \Symfony\Component\Form\FormInterface
   */
  private function createDeleteForm(Zwick $zwick)
  {
    return $this->createFormBuilder()
        ->setAction($this->generateUrl('zwick_delete', array('id' => $zwick->getId())))
        ->setMethod('DELETE')
        ->getForm();
  }

  /**
   * Displays a form to edit an existing Lab1_pomiar entity.
   *
   * @Route("/{id}/edit", name="zwick_edit")
   * @Method({"GET", "POST"})
   */
  public function editAction(Request $request, Zwick $zwick)
  {
    $deleteForm = $this->createDeleteForm($zwick);
    $editForm = $this->createForm('AppBundle\Form\ZwickEditType', $zwick);
    $editForm->handleRequest($request);
    $projectId = $zwick->getMaterial()->getProject()->getId();

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($zwick);
      $em->flush();

      $this->reportAction($zwick);

      return $this->redirect($this->generateUrl('zwick_show', array('id' => $zwick->getId())));
    }

    return $this->render(
        'zwick/edit.html.twig',
        array(
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'projectId' => $projectId,
        )
    );
  }
}
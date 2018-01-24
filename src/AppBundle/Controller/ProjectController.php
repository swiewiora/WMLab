<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Material;
use AppBundle\Entity\Project;
use AppBundle\Entity\Zwick;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Project controller.
 * @Route("/project")
 * @Security("has_role('ROLE_USER')")
 */
class ProjectController extends Controller
{
  /**
   * @Route("/new", name="project_new")
   */
  public function newAction(Request $request)
  {
    $project = new Project();
    $project->setUser($this->getUser());
    $form = $this->createForm('AppBundle\Form\ProjectType', $project);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($project);
      $em->flush();

      return $this->redirect(
          $this->generateUrl(
              'project_show',
              array('id' => $project->getId())
          )
      );
    }

    return $this->render(
        'project/show.html.twig',
        array(
            'project' => $project,
            'form' => $form->createView(),
        )
    );
  }

  /**
   * Displays a form to edit an existing entity.
   * @Route("/{id}/edit", name="project_edit")
   * @Method({"GET", "POST"})
   */
  public function editAction(Request $request, Project $project)
  {
    $deleteForm = $this->createDeleteForm($project);
    $editForm = $this->createForm('AppBundle\Form\ProjectType', $project);
    $editForm->handleRequest($request);
    $projectId = $project->getId();

    if ($editForm->isSubmitted() && $editForm->isValid() ) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($project);
      $em->flush();
      return $this->redirect($this->generateUrl('project_show', array('id' => $project->getId() ) ) );
    }

    return $this->render('project/edit.html.twig', array(
        'form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        'projectId' => $projectId,
    ));
  }

  /**
   * @Route("/{id}", name="project_show")
   * @Method("GET")
   */
  public function showAction(Project $project)
  {
    $deleteForm = $this->createDeleteForm($project);
    $materials = $project->getMaterials();
    $tasks = array();
    foreach ($materials as $material) {
      /** @var $material Material */
      $tasks = array_merge($tasks, $material->getTasks()->toArray());
    }

    return $this->render(
        'project/show.html.twig',
        array(
            'delete_form' => $deleteForm->createView(),
            'project' => $project,
            'tasks' => $tasks,
            'materials' => $materials,
        )
    );
  }

  /**
   * Deletes a Project entity.
   *
   * @Route("/{id}", name="project_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, Project $project)
  {
    $form = $this->createDeleteForm($project);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($project);
      $em->flush();
    }

    return $this->redirectToRoute('index');
  }

  /**
   * Creates a form to delete a Lab1_pomiar entity.
   *
   * @param Project $project The Project entity
   * @return \Symfony\Component\Form\FormInterface
   */
  private function createDeleteForm(Project $project)
  {
    return $this->createFormBuilder()
        ->setAction($this->generateUrl('project_delete', array('id' => $project->getId())))
        ->setMethod('DELETE')
        ->getForm();
  }
}

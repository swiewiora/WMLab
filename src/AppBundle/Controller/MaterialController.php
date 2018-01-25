<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Material;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Material controller.
 * @Route("/material")
 * @Security("has_role('ROLE_USER')")
 */
class MaterialController extends Controller
{
    /**
     * @Route("/new", name="material_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $material = new Material();
        $em = $this->getDoctrine()->getManager();
        $projectId = $request->query->get('project');
        $project = $em->find('AppBundle:Project', $projectId);
        $material->setProject($project);
        $form = $this->createForm('AppBundle\Form\MaterialType', $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($material);
            $em->flush();
            return $this->redirect($this->generateUrl('project_show',
                array('id' => $material->getProject()->getId())));
        }

        return $this->render('material/new.html.twig', array(
            'material' => $material,
            'form' => $form->createView(),
        ));
    }

  /**
   * Deletes a Material entity.
   *
   * @Route("/{id}", name="material_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, Material $material)
  {
    $projectId = $material->getProject()->getId();
    $form = $this->createDeleteForm($material);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($material);
      $em->flush();
    }
    return $this->redirectToRoute('project_show', array('id' => $projectId));
  }

  /**
   * Creates a form to delete a Lab1_pomiar entity.
   *
   * @param Material $material The Material entity
   * @return \Symfony\Component\Form\FormInterface
   */
  private function createDeleteForm(Material $material)
  {
    return $this->createFormBuilder()
        ->setAction($this->generateUrl('material_delete', array('id' => $material->getId())))
        ->setMethod('DELETE')
        ->getForm()
        ;
  }

  /**
   * Displays a form to edit an existing entity.
   *
   * @Route("/{id}/edit", name="material_edit")
   * @Method({"GET", "POST"})
   */
  public function editAction(Request $request, Material $material)
  {
    $deleteForm = $this->createDeleteForm($material);
    $editForm = $this->createForm('AppBundle\Form\MaterialType', $material);
    $editForm->handleRequest($request);
    $projectId = $material->getProject()->getId();

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($material);
      $em->flush();
      return $this->redirectToRoute('project_show', array('id' => $projectId));
    }

    return $this->render('material/edit.html.twig', array(
        'form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        'projectId' => $projectId,
    ));
  }
}
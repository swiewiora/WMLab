<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lab1_pomiar_tab;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Lab1_pomiar_tab controller.
 *
 * @Route("/lab1_pomiar_tab")
 */
class Lab1_pomiar_tabController extends Controller
{

    /**
     * Displays a form to edit an existing Lab1_pomiar_tab entity.
     *
     * @Route("/{id}/edit", name="lab1_pomiar_tab_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Lab1_pomiar_tab $lab1_pomiar_tab)
    {
        $deleteForm = $this->createDeleteForm($lab1_pomiar_tab);
        $editForm = $this->createForm('AppBundle\Form\Lab1_pomiar_tabType', $lab1_pomiar_tab);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lab1_pomiar_tab);
            $em->flush();

            return $this->redirectToRoute('lab1_pomiar_tab_edit', array('id' => $lab1_pomiar_tab->getId()));
        }

        return $this->render('lab1_pomiar_tab/edit.html.twig', array(
            'lab1_pomiar_tab' => $lab1_pomiar_tab,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="lab1_pomiar_tab_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lab1_pomiar_tab $lab1_pomiar_tab)
    {
        $lab1_pomiar = $lab1_pomiar_tab->getPomiar();
        $form = $this->createDeleteForm($lab1_pomiar_tab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lab1_pomiar_tab);
            $em->flush();
        }

        return $this->redirectToRoute('lab1_pomiar_new_step2', array('id' => $lab1_pomiar->getId()));
    }

    /*
     * Deletes a Lab1_pomiar_tab entity.
     *
     * @Route("/{id}", name="lab1_pomiar_tab_delete")
     * @Method("DELETE")
     */
   /* public function deleteAction(Request $request, Lab1_pomiar_tab $lab1_pomiar_tab)
    {
        $form = $this->createDeleteForm($lab1_pomiar_tab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lab1_pomiar_tab);
            $em->flush();
        }

        return $this->redirectToRoute('lab1_pomiar_tab_index');
    }*/

    /**
     * Creates a form to delete a Lab1_pomiar_tab entity.
     *
     * @param Lab1_pomiar_tab $lab1_pomiar_tab The Lab1_pomiar_tab entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lab1_pomiar_tab $lab1_pomiar_tab)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lab1_pomiar_tab_delete', array(
                'id' => $lab1_pomiar_tab->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

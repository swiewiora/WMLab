<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Lab2_pomiar_tab;
use AppBundle\Form\Lab2_pomiar_tabType;

/**
 * Lab2_pomiar_tab controller.
 *
 * @Route("/lab2_pomiar_tab")
 */
class Lab2_pomiar_tabController extends Controller
{
    /**
     * Lists all Lab2_pomiar_tab entities.
     *
     * @Route("/", name="lab2_pomiar_tab_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lab2_pomiar_tabs = $em->getRepository('AppBundle:Lab2_pomiar_tab')->findAll();

        return $this->render('lab2_pomiar_tab/index.html.twig', array(
            'lab2_pomiar_tabs' => $lab2_pomiar_tabs,
        ));
    }

    /**
     * Creates a new Lab2_pomiar_tab entity.
     *
     * @Route("/new", name="lab2_pomiar_tab_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lab2_pomiar_tab = new Lab2_pomiar_tab();
        $form = $this->createForm('AppBundle\Form\Lab2_pomiar_tabType', $lab2_pomiar_tab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lab2_pomiar_tab);
            $em->flush();

            return $this->redirectToRoute('lab2_pomiar_tab_show', array('id' => $lab2_pomiar_tab->getId()));
        }

        return $this->render('lab2_pomiar_tab/new.html.twig', array(
            'lab2_pomiar_tab' => $lab2_pomiar_tab,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Lab2_pomiar_tab entity.
     *
     * @Route("/{id}", name="lab2_pomiar_tab_show")
     * @Method("GET")
     */
    public function showAction(Lab2_pomiar_tab $lab2_pomiar_tab)
    {
        $deleteForm = $this->createDeleteForm($lab2_pomiar_tab);

        return $this->render('lab2_pomiar_tab/show.html.twig', array(
            'lab2_pomiar_tab' => $lab2_pomiar_tab,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Lab2_pomiar_tab entity.
     *
     * @Route("/{id}/edit", name="lab2_pomiar_tab_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Lab2_pomiar_tab $lab2_pomiar_tab)
    {
        $deleteForm = $this->createDeleteForm($lab2_pomiar_tab);
        $editForm = $this->createForm('AppBundle\Form\Lab2_pomiar_tabType', $lab2_pomiar_tab);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lab2_pomiar_tab);
            $em->flush();

            return $this->redirectToRoute('lab2_pomiar_tab_edit', array('id' => $lab2_pomiar_tab->getId()));
        }

        return $this->render('lab2_pomiar_tab/edit.html.twig', array(
            'lab2_pomiar_tab' => $lab2_pomiar_tab,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Lab2_pomiar_tab entity.
     *
     * @Route("/{id}", name="lab2_pomiar_tab_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lab2_pomiar_tab $lab2_pomiar_tab)
    {
        $form = $this->createDeleteForm($lab2_pomiar_tab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lab2_pomiar_tab);
            $em->flush();
        }

        return $this->redirectToRoute('lab2_pomiar_tab_index');
    }

    /**
     * Creates a form to delete a Lab2_pomiar_tab entity.
     *
     * @param Lab2_pomiar_tab $lab2_pomiar_tab The Lab2_pomiar_tab entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lab2_pomiar_tab $lab2_pomiar_tab)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lab2_pomiar_tab_delete', array('id' => $lab2_pomiar_tab->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

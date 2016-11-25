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
     * Lists all Lab1_pomiar_tab entities.
     *
     * @Route("/", name="lab1_pomiar_tab_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lab1_pomiar_tabs = $em->getRepository('AppBundle:Lab1_pomiar_tab')->findAll();

        return $this->render('lab1_pomiar_tab/index.html.twig', array(
            'lab1_pomiar_tabs' => $lab1_pomiar_tabs,
        ));
    }

    /**
     * Creates a new Lab1_pomiar_tab entity.
     *
     * @Route("/new", name="lab1_pomiar_tab_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
      $lab1_pomiar_tab = new Lab1_pomiar_tab();
      $form = $this->createForm('AppBundle\Form\Lab1_pomiar_tabType', $lab1_pomiar_tab);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($lab1_pomiar_tab);
        $em->flush();

        return $this->redirectToRoute('lab1_pomiar_tab_show', array('id' => $lab1_pomiar_tab->getId()));
      }

      return $this->render('lab1_pomiar_tab/new.html.twig', array(
        'lab1_pomiar_tab' => $lab1_pomiar_tab,
        'form' => $form->createView(),
      ));
    }

    /**
     * Finds and displays a Lab1_pomiar_tab entity.
     *
     * @Route("/{id}", name="lab1_pomiar_tab_show")
     * @Method("GET")
     */
    public function showAction(Lab1_pomiar_tab $lab1_pomiar_tab)
    {
        $deleteForm = $this->createDeleteForm($lab1_pomiar_tab);

        return $this->render('lab1_pomiar_tab/show.html.twig', array(
            'lab1_pomiar_tab' => $lab1_pomiar_tab,
            'delete_form' => $deleteForm->createView(),
        ));
    }

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

    /* TODO Deletes a Lab1_pomiar_tab entity.
     *
     *
     * @Route("/{id_pomiar_tab}/{id_pomiar}", name="lab1_pomiar_tab_delete")
     * @ParamConverter("lab1_pomiar", options={"mapping": {"id_pomiar": "id"}})
     * @ParamConverter("lab1_pomiar_tab", options={"mapping": {"id_pomiar_tab": "id"}})
     * @Method("DELETE")
     *
    public function deleteAction(Request $request, Lab1_pomiar $lab1_pomiar, Lab1_pomiar_tab $lab1_pomiar_tab)
    {
        //$lab1_pomiar = $lab1_pomiar_tab->getPomiar(); - nie działa
        $form = $this->createDeleteForm($lab1_pomiar_tab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lab1_pomiar_tab);
            $em->flush();
        }

        //return $this->redirectToRoute('lab1_pomiar_new_step2', array('id' => $lab1_pomiar->getId())); //- nie działa
        return $this->redirectToRoute('lab1_pomiar_tab_index');
    }*/

    /**
     * Deletes a Lab1_pomiar_tab entity.
     *
     * @Route("/{id}", name="lab1_pomiar_tab_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lab1_pomiar_tab $lab1_pomiar_tab)
    {
        $form = $this->createDeleteForm($lab1_pomiar_tab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lab1_pomiar_tab);
            $em->flush();
        }

        return $this->redirectToRoute('lab1_pomiar_tab_index');
    }

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
            ->setAction($this->generateUrl('lab1_pomiar_tab_delete', array('id' => $lab1_pomiar_tab->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

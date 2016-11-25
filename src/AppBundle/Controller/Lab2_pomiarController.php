<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Lab2_pomiar;
use AppBundle\Form\Lab2_pomiarType;

/**
 * Lab2_pomiar controller.
 *
 * @Route("/lab2_pomiar")
 */
class Lab2_pomiarController extends Controller
{
    /**
     * Lists all Lab2_pomiar entities.
     *
     * @Route("/", name="lab2_pomiar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lab2_pomiars = $em->getRepository('AppBundle:Lab2_pomiar')->findAll();

        return $this->render('lab2_pomiar/index.html.twig', array(
            'lab2_pomiars' => $lab2_pomiars,
        ));
    }

    /**
     * Creates a new Lab2_pomiar entity.
     *
     * @Route("/new", name="lab2_pomiar_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lab2_pomiar = new Lab2_pomiar();
        $form = $this->createForm('AppBundle\Form\Lab2_pomiarType', $lab2_pomiar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lab2_pomiar);
            $em->flush();

            return $this->redirectToRoute('lab2_pomiar_show', array('id' => $lab2_pomiar->getId()));
        }

        return $this->render('lab2_pomiar/new.html.twig', array(
            'lab2_pomiar' => $lab2_pomiar,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Lab2_pomiar entity.
     *
     * @Route("/{id}", name="lab2_pomiar_show")
     * @Method("GET")
     */
    public function showAction(Lab2_pomiar $lab2_pomiar)
    {
        $deleteForm = $this->createDeleteForm($lab2_pomiar);

        return $this->render('lab2_pomiar/show.html.twig', array(
            'lab2_pomiar' => $lab2_pomiar,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Lab2_pomiar entity.
     *
     * @Route("/{id}/edit", name="lab2_pomiar_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Lab2_pomiar $lab2_pomiar)
    {
        $deleteForm = $this->createDeleteForm($lab2_pomiar);
        $editForm = $this->createForm('AppBundle\Form\Lab2_pomiarType', $lab2_pomiar);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lab2_pomiar);
            $em->flush();

            return $this->redirectToRoute('lab2_pomiar_edit', array('id' => $lab2_pomiar->getId()));
        }

        return $this->render('lab2_pomiar/edit.html.twig', array(
            'lab2_pomiar' => $lab2_pomiar,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Lab2_pomiar entity.
     *
     * @Route("/{id}", name="lab2_pomiar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lab2_pomiar $lab2_pomiar)
    {
        $form = $this->createDeleteForm($lab2_pomiar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lab2_pomiar);
            $em->flush();
        }

        return $this->redirectToRoute('lab2_pomiar_index');
    }

    /**
     * Creates a form to delete a Lab2_pomiar entity.
     *
     * @param Lab2_pomiar $lab2_pomiar The Lab2_pomiar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lab2_pomiar $lab2_pomiar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lab2_pomiar_delete', array('id' => $lab2_pomiar->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a new Lab2_pomiar entity and fills with values.
     *
     * @Route("/new/step1", name="lab2_pomiar_new_step1")
     * @Method({"GET", "POST"})
     */
    public function newAction_step1(Request $request)
    {
        $lab2_pomiar = new Lab2_pomiar();
        $form = $this->createForm('AppBundle\Form\Lab2_pomiar_step1Type', $lab2_pomiar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lab2_pomiar);
            $em->flush();

            return $this->redirectToRoute('lab2_pomiar_new_step2', array('id' => $lab2_pomiar->getId()));
        }

        return $this->render('lab2_pomiar/new_step1.html.twig', array(
            'lab2_pomiar' => $lab2_pomiar,
            'form' => $form->createView(),
        ));
    }

    /**
     * Shows data from step 2,
     * Creates Lab2_pomiar_tab entity connected with Lab2_pomiar entity,
     * Shows Lab2_pomiar_tab entities connected with Lab1_pomiar.
     *
     * @Route("/new/step2/{id}", name="lab2_pomiar_new_step2")
     * @Method({"GET", "POST"})
     */
    public function newAction_step2(Lab2_pomiar $lab2_pomiar, Request $request)
    {
        // To create Delete button
        $deleteForm = $this->createDeleteForm($lab2_pomiar);

        // To list Lab1_pomiar_tab entities
        $em = $this->getDoctrine()->getManager();
        $lab2_pomiar_tabs = $em->getRepository('AppBundle:Lab2_pomiar_tab')->findBy(array('pomiar' => $lab2_pomiar->getId()));

        // Create Delete button for each lab1_pomiar_tab
        $deleteForms = array();
        foreach ($lab2_pomiar_tabs as $lab2_pomiar_tab) {
            $deleteForms[$lab2_pomiar_tab->getId()] = $this->createDeleteTabForm($lab2_pomiar_tab)->createView();
        }

        // To create Lab1_pomiar_tab form
        $lab2_pomiar_tab = new Lab2_pomiar_tab();
        $lab2_pomiar_tab->setPomiar($lab2_pomiar); // Join new etities with Lab1_pomiar entry
        $form = $this->createForm('AppBundle\Form\Lab2_pomiar_step2Type', $lab2_pomiar_tab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lab2_pomiar_tab);
            $em->flush();

            return $this->redirectToRoute('lab2_pomiar_new_step2', array('id' => $lab2_pomiar->getId()));
        }

        return $this->render('lab2_pomiar/new_step2.html.twig', array(
            'lab2_pomiar' => $lab2_pomiar,
            'delete_form' => $deleteForm->createView(),
            'lab2_pomiar_tabs' => $lab2_pomiar_tabs,
            'delete_form_tab' => $deleteForms,
            'form' => $form->createView(),
        ));
    }

    /**
     * Adds the rest of values to previously created Lab1_pomiar entity.
     *
     * @Route("/new/step3/{id}", name="lab2_pomiar_new_step3")
     * @Method({"GET", "POST"})
     */
    public function newAction_step3(Lab2_pomiar $lab2_pomiar, Request $request)
    {
        $form = $this->createForm('AppBundle\Form\Lab2_pomiar_step3Type', $lab2_pomiar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lab2_pomiar);
            $em->flush();

            return $this->redirectToRoute('lab2_pomiar_show', array('id' => $lab2_pomiar->getId()));
        }

        return $this->render('lab2_pomiar/new_step3.html.twig', array(
            'lab2_pomiar' => $lab2_pomiar,
            'form' => $form->createView(),
        ));
    }
}

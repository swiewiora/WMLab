<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lab1_pomiar;
use AppBundle\Entity\Lab1_pomiar_tab;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Lab1_pomiar controller.
 *
 * @Route("/lab1_pomiar")
 * @Security("has_role('ROLE_USER')")
 */
class Lab1_pomiarController extends Controller
{
    /**
     * Lists all Lab1_pomiar entities.
     *
     * @Route("/", name="lab1_pomiar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lab1_pomiars = $em->getRepository('AppBundle:Lab1_pomiar')->findBy(array('zespol' => $this->getUser()->getZespol()));

        return $this->render('lab1_pomiar/index.html.twig', array(
            'lab1_pomiars' => $lab1_pomiars,
        ));
    }

    /**
     * Finds and displays a Lab1_pomiar entity.
     *
     * @Route("/{id}/show", name="lab1_pomiar_show")
     * @Method("GET")
     */
    public function showAction(Lab1_pomiar $lab1_pomiar)
    {
        $deleteForm = $this->createDeleteForm($lab1_pomiar);

        $em = $this->getDoctrine()->getManager();
        $lab1_pomiar_tabs = $em->getRepository('AppBundle:Lab1_pomiar_tab')->findBy(array('pomiar' => $lab1_pomiar->getId()));

        return $this->render('lab1_pomiar/show.html.twig', array(
            'lab1_pomiar' => $lab1_pomiar,
            'delete_form' => $deleteForm->createView(),
            'lab1_pomiar_tabs' => $lab1_pomiar_tabs
        ));
    }

    /**
     * Displays a form to edit an existing Lab1_pomiar entity.
     *
     * @Route("/{id}/edit", name="lab1_pomiar_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Lab1_pomiar $lab1_pomiar)
    {
        $deleteForm = $this->createDeleteForm($lab1_pomiar);
        $editForm = $this->createForm('AppBundle\Form\Lab1_pomiarType', $lab1_pomiar);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $lab1_pomiar->preUpdate();
            $em = $this->getDoctrine()->getManager();
            $em->persist($lab1_pomiar);
            $em->flush();

            return $this->redirectToRoute('lab1_pomiar_edit', array('id' => $lab1_pomiar->getId()));
        }

        return $this->render('lab1_pomiar/edit.html.twig', array(
            'lab1_pomiar' => $lab1_pomiar,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Lab1_pomiar entity.
     *
     * @Route("/{id}", name="lab1_pomiar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lab1_pomiar $lab1_pomiar)
    {
        $form = $this->createDeleteForm($lab1_pomiar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lab1_pomiar);
            $em->flush();
        }

        return $this->redirectToRoute('lab1_pomiar_index');
    }

    /**
     * Creates a form to delete a Lab1_pomiar entity.
     *
     * @param Lab1_pomiar $lab1_pomiar The Lab1_pomiar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lab1_pomiar $lab1_pomiar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lab1_pomiar_delete', array('id' => $lab1_pomiar->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a form to delete a Lab1_pomiar_tab records.
     *
     * @Route("/{lab1_pomiar_tab}/", name="lab1_pomiar_tab_delete_step2")
     * @Method("DELETE")
     */
    public function deleteTabFromStep2Action(Request $request, Lab1_pomiar_tab $lab1_pomiar_tab)
    {
        $lab1_pomiar = $lab1_pomiar_tab->getPomiar();
        $form = $this->createDeleteTabForm($lab1_pomiar_tab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lab1_pomiar_tab);
            $em->flush();
        }

        return $this->redirectToRoute('lab1_pomiar_new_step2', array('id' => $lab1_pomiar->getId()));
    }

    /**
     * Creates a form to delete a Lab1_pomiar_tab entity.
     *
     * @param Lab1_pomiar_tab $lab1_pomiar_tab The Lab1_pomiar_tab entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteTabForm(Lab1_pomiar_tab $lab1_pomiar_tab)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lab1_pomiar_tab_delete_step2', array(
                'lab1_pomiar_tab' => $lab1_pomiar_tab->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Creates a new Lab1_pomiar entity and fills with l0, d0 and Zespol.
     *
     * @Route("/new/step1", name="lab1_pomiar_new_step1")
     * @Method({"GET", "POST"})
     */
    public function newAction_step1(Request $request)
    {
        $lab1_pomiar = new Lab1_pomiar();
        $lab1_pomiar->setZespol($this->getUser()->getZespol());
        $form = $this->createForm('AppBundle\Form\Lab1_pomiar_step1Type', $lab1_pomiar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lab1_pomiar);
            $em->flush();

            return $this->redirectToRoute('lab1_pomiar_new_step2', array('id' => $lab1_pomiar->getId()));
        }

        return $this->render('lab1_pomiar/new_step1.html.twig', array(
            'lab1_pomiar' => $lab1_pomiar,
            'form' => $form->createView(),
        ));
    }

    /**
     * Shows data from step 1,
     * Creates Lab1_pomiar_tab entity connected with Lab1_pomiar entity,
     * Shows Lab1_pomiar_tab entities connected with Lab1_pomiar.
     *
     * @Route("/new/step2/{id}", name="lab1_pomiar_new_step2")
     * @Method({"GET", "POST"})
     */
    public function newAction_step2(Lab1_pomiar $lab1_pomiar, Request $request)
    {
        // To create Delete button
        $deleteForm = $this->createDeleteForm($lab1_pomiar);

        // To list Lab1_pomiar_tab entities
        $em = $this->getDoctrine()->getManager();
        $lab1_pomiar_tabs = $em->getRepository('AppBundle:Lab1_pomiar_tab')
            ->findBy(array('pomiar' => $lab1_pomiar->getId()));

        $deleteForms = array();
        foreach ($lab1_pomiar_tabs as $lab1_pomiar_tab) {
            $deleteForms[$lab1_pomiar_tab->getId()] =
                $this->createDeleteTabForm($lab1_pomiar_tab)->createView();
        }

        // To create Lab1_pomiar_tab form
        $lab1_pomiar_tab = new Lab1_pomiar_tab();
        $lab1_pomiar_tab->setPomiar($lab1_pomiar); // Join new etities with Lab1_pomiar entry
        $form = $this->createForm('AppBundle\Form\Lab1_pomiar_step2Type', $lab1_pomiar_tab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lab1_pomiar_tab);
            $em->flush();

            return $this->redirectToRoute('lab1_pomiar_new_step2', array('id' => $lab1_pomiar->getId()));
        }

        return $this->render('lab1_pomiar/new_step2.html.twig', array(
            'lab1_pomiar' => $lab1_pomiar,
            'delete_form' => $deleteForm->createView(),
            'lab1_pomiar_tabs' => $lab1_pomiar_tabs,
            'delete_form_tab' => $deleteForms,
            'form' => $form->createView(),
        ));
    }

    /**
     * Adds du, lu and Pm to previously created Lab1_pomiar entity.
     *
     * @Route("/new/step3/{id}", name="lab1_pomiar_new_step3")
     * @Method({"GET", "POST"})
     */
    public function newAction_step3(Lab1_pomiar $lab1_pomiar, Request $request)
    {
        $form = $this->createForm('AppBundle\Form\Lab1_pomiar_step3Type', $lab1_pomiar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lab1_pomiar);
            $em->flush();

            return $this->redirectToRoute('lab1_pomiar_show', array('id' => $lab1_pomiar->getId()));
        }

        return $this->render('lab1_pomiar/new_step3.html.twig', array(
            'lab1_pomiar' => $lab1_pomiar,
            'form' => $form->createView(),
        ));
    }


}

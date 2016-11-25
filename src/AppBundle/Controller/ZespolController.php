<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Zespol;
use AppBundle\Form\ZespolType;

/**
 * Zespol controller.
 *
 * @Route("/zespol")
 */
class ZespolController extends Controller
{
    /**
     * Lists all Zespol entities.
     *
     * @Route("/", name="zespol_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $zespols = $em->getRepository('AppBundle:Zespol')->findAll();

        return $this->render('zespol/index.html.twig', array(
            'zespols' => $zespols,
        ));
    }

    /**
     * Creates a new Zespol entity.
     *
     * @Route("/new", name="zespol_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $zespol = new Zespol();
        $form = $this->createForm('AppBundle\Form\ZespolType', $zespol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($zespol);
            $em->flush();

            return $this->redirectToRoute('zespol_show', array('id' => $zespol->getId()));
        }

        return $this->render('zespol/new.html.twig', array(
            'zespol' => $zespol,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Zespol entity.
     *
     * @Route("/{id}", name="zespol_show")
     * @Method("GET")
     */
    public function showAction(Zespol $zespol)
    {
        $deleteForm = $this->createDeleteForm($zespol);

        return $this->render('zespol/show.html.twig', array(
            'zespol' => $zespol,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Zespol entity.
     *
     * @Route("/{id}/edit", name="zespol_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Zespol $zespol)
    {
        $deleteForm = $this->createDeleteForm($zespol);
        $editForm = $this->createForm('AppBundle\Form\ZespolType', $zespol);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($zespol);
            $em->flush();

            return $this->redirectToRoute('zespol_edit', array('id' => $zespol->getId()));
        }

        return $this->render('zespol/edit.html.twig', array(
            'zespol' => $zespol,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Zespol entity.
     *
     * @Route("/{id}", name="zespol_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Zespol $zespol)
    {
        $form = $this->createDeleteForm($zespol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($zespol);
            $em->flush();
        }

        return $this->redirectToRoute('zespol_index');
    }

    /**
     * Creates a form to delete a Zespol entity.
     *
     * @param Zespol $zespol The Zespol entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Zespol $zespol)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('zespol_delete', array('id' => $zespol->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace AppBundle\Controller;


use AppBundle\Calc\Lab1Calc;
use AppBundle\Entity\Lab1_pomiar;
use AppBundle\Entity\Lab1_wynik;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;

/**
 * Lab1_wynik controller.
 *
 * @Route("/lab1_wynik")
 */
class Lab1_wynikController extends Controller
{
    /**
     * Lists all Lab1_wynik entities.
     *
     * @Route("/", name="lab1_wynik_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lab1_wyniks = $em->getRepository('AppBundle:Lab1_wynik')->findAll();

        $lab1_pomiars = $em->getRepository('AppBundle:Lab1_pomiar')->findAll();

        return $this->render('lab1_wynik/index.html.twig', array(
            'lab1_wyniks' => $lab1_wyniks,
            'lab1_pomiars' => $lab1_pomiars,
        ));
    }

    /**
     * Finds and displays a Lab1_wynik entity.
     *
     * @Route("/{id}", name="lab1_wynik_show")
     * @Method("GET")
     */
    public function showAction(Lab1_wynik $lab1_wynik)
    {
        $em = $this->getDoctrine()->getManager();
        $zespol = $lab1_wynik->getZespol();
        $lab1_pomiar = $em->getRepository('AppBundle:Lab1_pomiar')->findOneBy(array('zespol' => $zespol));
        $lab1_wynik_tab = $lab1_wynik->getTab();

        return $this->render('lab1_wynik/show.html.twig', array(
            'lab1_wynik' => $lab1_wynik,
            'lab1_pomiar' => $lab1_pomiar,
            'lab1_wynik_tabs' => $lab1_wynik_tab,
        ));
    }

    /**
     * Calculates and displays a Lab1_wynik entity.
     *
     * @Route("/generate/{id}", name="lab1_calc")
     * @Method("GET")
     */
    public function calcAction(Lab1_pomiar $lab1_pomiar)
    {
        $em = $this->getDoctrine()->getManager();
        $lab1_wynik = $em->getRepository('AppBundle:Lab1_wynik')
            ->findOneBy(array('zespol' => $this->getUser()->getZespol()));
        if($lab1_wynik) {
            $em->remove($lab1_wynik);
            $em->flush();
        }

        $lab1_calc = new Lab1Calc($lab1_pomiar);

        $lab1_wynik = $lab1_calc->getWynik();
        $em->persist($lab1_wynik);
        $em->flush();

        $lab1_wynik_tab = $lab1_calc->getWynikTab();
        foreach($lab1_wynik_tab as $item) {
            $em->persist($item);
            $em->flush();
        }

        return $this->redirectToRoute('lab1_wynik_show', array('id' => $lab1_wynik->getId()));
    }

    /**
     * Deletes a Lab1_wynik entity.
     *
     * @Route("/{id}", name="lab1_wynik_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lab1_wynik $lab1_wynik)
    {
        $form = $this->createDeleteForm($lab1_wynik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lab1_wynik);
            $em->flush();
        }

        return $this->redirectToRoute('lab1_wynik_index');
    }

    /**
     * Creates a form to delete a Lab1_wynik entity.
     *
     * @param Lab1_wynik $lab1_wynik The Lab1_wynik entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lab1_wynik $lab1_wynik)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lab1_wynik_delete', array('id' => $lab1_wynik->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
    
}

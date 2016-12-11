<?php

namespace AppBundle\Controller;


use AppBundle\Calc\Lab2Calc;
use AppBundle\Entity\Lab1_pomiar;
use AppBundle\Entity\Lab1_wynik;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

        return $this->render('lab1_wynik/index.html.twig', array(
            'lab1_wyniks' => $lab1_wyniks,
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

        return $this->render('lab1_wynik/show.html.twig', array(
            'lab1_wynik' => $lab1_wynik,
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
        $lab1_calc = new Lab2Calc();
        $lab1_wynik = $lab1_calc->getWynik($lab1_pomiar);

        $em = $this->getDoctrine()->getManager();
        $em->persist($lab1_wynik);
        $em->flush();

        return $this->redirectToRoute('lab1_wynik_show', array('id' => $lab1_wynik->getId()));
    }
}

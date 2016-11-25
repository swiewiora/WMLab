<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Lab1_wynik_tab;

/**
 * Lab1_wynik_tab controller.
 *
 * @Route("/lab1_wynik_tab")
 */
class Lab1_wynik_tabController extends Controller
{
    /**
     * Lists all Lab1_wynik_tab entities.
     *
     * @Route("/", name="lab1_wynik_tab_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lab1_wynik_tabs = $em->getRepository('AppBundle:Lab1_wynik_tab')->findAll();

        return $this->render('lab1_wynik_tab/index.html.twig', array(
            'lab1_wynik_tabs' => $lab1_wynik_tabs,
        ));
    }

    /**
     * Finds and displays a Lab1_wynik_tab entity.
     *
     * @Route("/{id}", name="lab1_wynik_tab_show")
     * @Method("GET")
     */
    public function showAction(Lab1_wynik_tab $lab1_wynik_tab)
    {

        return $this->render('lab1_wynik_tab/show.html.twig', array(
            'lab1_wynik_tab' => $lab1_wynik_tab,
        ));
    }
}

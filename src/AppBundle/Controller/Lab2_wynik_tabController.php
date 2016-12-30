<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Lab2_wynik_tab;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Lab2_wynik_tab controller.
 *
 * @Route("/lab2_wynik_tab")
 * @Security("has_role('ROLE_USER')")
 */
class Lab2_wynik_tabController extends Controller
{
    /**
     * Lists all Lab2_wynik_tab entities.
     *
     * @Route("/", name="lab2_wynik_tab_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lab2_wynik_tabs = $em->getRepository('AppBundle:Lab2_wynik_tab')->findAll();

        return $this->render('lab2_wynik_tab/index.html.twig', array(
            'lab2_wynik_tabs' => $lab2_wynik_tabs,
        ));
    }

    /**
     * Finds and displays a Lab2_wynik_tab entity.
     *
     * @Route("/{id}", name="lab2_wynik_tab_show")
     * @Method("GET")
     */
    public function showAction(Lab2_wynik_tab $lab2_wynik_tab)
    {

        return $this->render('lab2_wynik_tab/show.html.twig', array(
            'lab2_wynik_tab' => $lab2_wynik_tab,
        ));
    }
}

<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Lab2_wynik;

/**
 * Lab2_wynik controller.
 *
 * @Route("/lab2_wynik")
 */
class Lab2_wynikController extends Controller
{
    /**
     * Lists all Lab2_wynik entities.
     *
     * @Route("/", name="lab2_wynik_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lab2_wyniks = $em->getRepository('AppBundle:Lab2_wynik')->findAll();

        return $this->render('lab2_wynik/index.html.twig', array(
            'lab2_wyniks' => $lab2_wyniks,
        ));
    }

    /**
     * Finds and displays a Lab2_wynik entity.
     *
     * @Route("/{id}", name="lab2_wynik_show")
     * @Method("GET")
     */
    public function showAction(Lab2_wynik $lab2_wynik)
    {

        return $this->render('lab2_wynik/show.html.twig', array(
            'lab2_wynik' => $lab2_wynik,
        ));
    }
}

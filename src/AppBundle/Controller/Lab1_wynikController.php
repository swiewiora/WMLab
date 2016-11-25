<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Lab1_wynik;

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
}

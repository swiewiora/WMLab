<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Lab2_wynik;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Lab2_wynik controller.
 *
 * @Route("/lab2_wynik")
 * @Security("has_role('ROLE_USER')")
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

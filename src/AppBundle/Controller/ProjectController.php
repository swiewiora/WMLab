<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Lab1_pomiar controller.
 *
 * @Route("/projects")
 */
class ProjectController extends Controller
{
    /**
     * @Route("/", name="projects")
     */
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}

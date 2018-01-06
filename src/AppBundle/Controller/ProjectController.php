<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Lab1_pomiar controller.
 *
 * @Route("/project")
 */
class ProjectController extends Controller
{
    public function index() {
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository('AppBundle:Project')->findAll();
        return $projects;
    }

    /**
     * @Route("/new", name="project_new")
     */
    public function newAction() {
        $project = new Project();
        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();
        return $this->redirect($this->generateUrl('project_show', array('id' => $project->getId())));
    }
}

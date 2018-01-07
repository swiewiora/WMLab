<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Project controller.
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

    /**
     * @Route("/{id}", name="project_show")
     * @Method("GET")
     */
    public function showAction(Project $project)
    {
        //TODO delete form
//        $deleteForm = $this->createDeleteForm($project);
//        $em = $this->getDoctrine()->getManager();
//        $lab1_pomiar_tabs = $em->getRepository('AppBundle:Project')->findBy(array('id' => $project->getId()));
        $materials = $project->getMaterials();
        $tasks = array();
        foreach ($materials as $material) {
            array_push($tasks, $material->getTasks());
        }

        return $this->render('project/show.html.twig', array(
//            'delete_form' => $deleteForm->createView(),
            'project' => $project,
            'tasks' => $tasks,
            'materials' => $materials,
        ) );
    }
}

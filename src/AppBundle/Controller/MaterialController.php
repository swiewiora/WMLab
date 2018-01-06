<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Material;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Material controller.
 *
 * @Route("/material")
 */
class MaterialController extends Controller
{
    public function index () {
        $em = $this->getDoctrine()->getManager();
        $materials = $em->getRepository('AppBundle:Material')->findAll();
        return $materials;
    }

    /**
     * @Route("/new", name="material_new")
     */
    public function newAction(Request $request) {
        $material = new Material();
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('AppBundle:Project')
            ->findBy(array('id', $request->query->get('project') ) );
        $material->setProject($project);
        $form = $this->createForm('AppBundle\Form\MaterialType', $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($material);
            $em->flush();
            return $this->redirect($this->generateUrl('project_show', array('id' => $material->getProject()->getId())));
        }

        return $this->render('material/new.html.twig', array(
            'material' => $material,
            'form' => $form->createView(),
        ));
    }
}

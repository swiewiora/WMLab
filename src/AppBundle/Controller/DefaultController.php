<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $auth_checker = $this->get('security.authorization_checker');
      $projects = null;
      if ($auth_checker->isGranted('ROLE_ADMIN') )
        $projects = $em->getRepository('AppBundle:Project')->findAll();
      else {
        if ($this->getUser() )
          $projects = $this->getUser()->getProjects();
      }
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/blank", name="blank")
     */
    public function blankAction(Request $request)
    {
        return $this->render('default/blank.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2017-01-09
 * Time: 01:22
 */

namespace AppBundle\Admin;

use AppBundle\Controller\ZespolController;
use AppBundle\Entity\Zespol;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Lab1_pomiar_tab controller.
 *
 * @Route("/")
 * @Security("has_role('ROLE_ADMIN')")
 */
class DashboardController extends Controller
{
  /**
   * @Route("/dashboard", name="dashboard")
   * @Method("GET")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $users = $em->getRepository('UserBundle:User')->findAll();
//    $zespoly = $em->getRepository('AppBundle:Zespol')->findAll();
//
//    foreach ($zespoly as $zespol) {
//      $deleteForm = $this->createDeleteZespolForm($zespol);
//    }

    return $this->render(
        'admin/dashboard.html.twig',
        array(
            'users' => $users,
//            'zespoly' => $zespoly,
//            'delete_form' => $deleteForm->createView(),
        )
    );
  }

  /**
   * @Route("/admin/enable", name="user_enable")
   */
  public function enableUserAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('UserBundle:User')->find($request->get('id'));
    $user->setEnabled(true);
    $userManager = $this->get('fos_user.user_manager');
    $userManager->updateUser($user);
    return $this->redirectToRoute('dashboard');
  }

  /**
   * @Route("/admin/disable", name="user_disable")
   */
  public function disableUserAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('UserBundle:User')->find($request->get('id'));
    $user->setEnabled(false);
    $userManager = $this->get('fos_user.user_manager');
    $userManager->updateUser($user);
    return $this->redirectToRoute('dashboard');
  }

  /**
   * Creates a form to delete a Zespol entity.
   *
   * @param Zespol $zespol The Zespol entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteZespolForm(Zespol $zespol)
  {
    return $this->createFormBuilder()
        ->setAction($this->generateUrl('zespol_delete', array('id' => $zespol->getId())))
        ->setMethod('DELETE')
        ->getForm();
  }
}
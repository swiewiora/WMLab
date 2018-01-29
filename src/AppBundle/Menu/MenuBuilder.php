<?php
/**
 * Created by PhpStorm.
 * User: Seba
 * Date: 2018-01-22
 * Time: 15:24
 */

namespace AppBundle\Menu;
use AppBundle\Entity\Material;
use AppBundle\Entity\Project;
use AppBundle\Entity\Zwick;
use Doctrine\ORM\EntityManager;
use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use UserBundle\Entity\User;

class MenuBuilder
{
  private $factory, $em, $tokenStorage, $checker;

  /**
   * Add any other dependency you need
   * @param FactoryInterface $factory
   * @param EntityManager $em
   * @param TokenStorage $tokenStorage
   * @param AuthorizationChecker $checker
   */
  public function __construct(FactoryInterface $factory, EntityManager $em, TokenStorage $tokenStorage,
      AuthorizationChecker $checker)
  {
    $this->factory = $factory;
    $this->em = $em;
    $this->tokenStorage = $tokenStorage;
    $this->checker = $checker;
  }

  public function mainMenu(array $options)
  {
    $menu = $this->factory->createItem(
        'root',
        array(
            'childrenAttributes' => array(
                'class' => 'nav',
                'id' => 'side-menu',
            ),
    ) );
    if ($this->checker->isGranted('ROLE_ADMIN') ) {
      $menu->addChild(
          'Dashboard',
          array(
              'route' => 'dashboard',
              'label' => '<i class="fa fa-dashboard fa-fw"></i> Kokpit',
              'extras' => array('safe_label' => true),
          )
      );
    }
    $menu->addChild(
        'Labs',
        array (
            'uri' => '#',
            'label' => ' <i class="fa fa-flask fa-fw"></i> Laboratorium<span class="fa arrow"></span>',
            'extras' => array('safe_label' => true),
        )
    );
    $menu['Labs']->setChildrenAttribute('class', 'nav nav-second-level');
    /** @var User $user */
    $user = $this->tokenStorage->getToken()->getUser();
    $projects = null;
    if ($this->checker->isGranted('ROLE_ADMIN') ) {
      $projects = $this->em->getRepository('AppBundle:Project')->findAll();
    } elseif ($user != "anon.") {
      $projects = $user->getProjects();
    }

    if ($projects == false) return $menu;
    foreach ($projects as $project) {
      /** @var Project $project */
      $projectKey = 'Project'.$project->getId();
      $menu['Labs']->addChild(
          $projectKey,
          array(
              'route' => 'project_show',
              'routeParameters' => ['id' => $project->getId()],
              'label' => ' <i class="fa fa-sitemap fa-fw"></i> '.$project->getName().'<span class="fa arrow"></span>',
              'extras' => array('safe_label' => true),
          )
      );
      $menu['Labs'][$projectKey]->setChildrenAttribute('class', 'nav nav-third-level');
      $materials = $project->getMaterials();
      foreach ($materials as $material) {
        /** @var Material $material */
        $materialKey = 'Material'.$material->getId();
        $menu['Labs'][$projectKey]->addChild(
            $materialKey,
            array (
                'route' => 'material_edit',
                'routeParameters' => ['id' => $material->getId()],
                'label' => '<i class="fa fa-edit fa-fw"></i> ' . $material->getAlloyName(),
                'extras' => array('safe_label' => true),
            )
        );
        $tasks = $material->getTasks();
        foreach ($tasks as $task) {
          /** @var Zwick $task */
          $taskKey = 'Task'.$task->getId();
          $menu['Labs'][$projectKey]->addChild(
              $taskKey,
              array(
                  'route' => 'zwick_show',
                  'routeParameters' => ['id' => $task->getId()],
                  'label' => '<i class="fa fa-bar-chart-o fa-fw"></i> ' .
                      substr($task->getTaskName(), 0, 20),
                  'extras' => array('safe_label' => true),
              )
          );
        }
      }
    }
    return $menu;
  }
}
<?php

namespace AppBundle\Menu;

use AppBundle\Entity\Material;
use AppBundle\Entity\Project;
use AppBundle\Entity\Zwick;
use Knp\Menu\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class Builder implements ContainerAwareInterface
{
  use ContainerAwareTrait;

  public function mainMenu(FactoryInterface $factory, array $options)
  {
    $menu = $factory->createItem(
        'root',
        array(
            'childrenAttributes' => array(
                'class' => 'nav',
                'id' => 'side-menu',
            ),
        )
    );
    $menu->addChild(
        'Labs',
        array(
            'uri' => '#',
            'label' => ' <i class="fa fa-sitemap fa-fw"></i> Laboratorium<span class="fa arrow"></span>',
            'extras' => array('safe_label' => true),
        )
    );
    $menu['Labs']->setChildrenAttribute('class', 'nav nav-second-level');
    $em = $this->container->get('doctrine')->getManager();
    $projects = $em->getRepository('UserBundle:User')->findAll(); //TODO user rights (register service)
    foreach ($projects as $project) {
      /**
       * @var Project $project
       */
      $projectKey = 'Project'.$project->getId();
      $menu['Labs']->addChild(
          $projectKey,
          array(
              'route' => 'project_show',
              'routeParameters' => ['id' => $project->getId()],
              'label' => 'Projekt <span class="fa arrow"></span>',
              'extras' => array('safe_label' => true),
          )
      );
      $menu['Labs'][$projectKey]->setChildrenAttribute('class', 'nav nav-third-level');
      $materials = $project->getMaterials();
      foreach ($materials as $material) {
        /**
         * @var Material $material
         */
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
          /**
           * @var Zwick $task
           */
          $taskKey = 'Material'.$task->getId();
          $menu['Labs'][$projectKey]->addChild(
              $taskKey,
              array(
                  'route' => 'zwick_show',
                  'routeParameters' => ['id' => $task->getId()],
                  'label' => '<i class="fa fa-bar-chart-o fa-fw"></i> Zadanie',
                  'extras' => array('safe_label' => true),
              )
          );
        }
      }
    }

    $checker = $this->container->get('security.authorization_checker');
    if ($checker->isGranted('ROLE_ADMIN')) {

      $menu->addChild(
          'Dashboard',
          array(
              'route' => 'dashboard',
              'label' => '<i class="fa fa-dashboard fa-fw"></i> Kokpit',
              'extras' => array('safe_label' => true),
          )
      );

      /*$menu->addChild(
          'Settings',
          array(
              'uri' => '#',
              'label' => '<i class="fa fa-wrench fa-fw"></i> Ustawienia',
              'extras' => array('safe_label' => true),
          )
      );*/
    }

    return $menu;
  }
}


/*// access services from the container!
$em = $this->container->get('doctrine')->getManager();
// findMostRecent and Blog are just imaginary examples
$blog = $em->getRepository('AppBundle:Blog')->findMostRecent();

$menu->addChild('Latest Blog Post', array(
    'route' => 'blog_show',
    'routeParameters' => array('id' => $blog->getId())
));

// create another menu item
$menu->addChild('About Me', array('route' => 'about'));
// you can also add sub level's to your menu's as follows
$menu['About Me']->addChild('Edit profile', array('route' => 'edit_profile'));

// ... add more children*/
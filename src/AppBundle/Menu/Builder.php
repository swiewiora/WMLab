<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes'    => array(
                'class'             => 'nav',
                'id'                => 'side-menu',
            ),
        ));
//        $menu->setChildrenAttribute('class',null);

        $menu->addChild('Labs', array(
            'uri' => '#',
            'label' => ' <i class="fa fa-sitemap fa-fw"></i> Laboratorium<span class="fa arrow"></span>',
            'extras' => array('safe_label' => true),
        ));
        $menu['Labs']->setChildrenAttribute('class', 'nav nav-second-level');
        $menu['Labs']->addChild('Lab1', array(
            'uri' => '#',
            'label' => '1. Próba statyczna rozciągania<span class="fa arrow"></span>',
            'extras' => array('safe_label' => true),
        ));
        $menu['Labs']['Lab1']->setChildrenAttribute('class', 'nav nav-third-level');
        $menu['Labs']['Lab1']->addChild('Pomiary', array(
            'route' => 'lab1_pomiar_index',
            'label' => '<i class="fa fa-edit fa-fw"></i> Pomiary',
            'extras' => array('safe_label' => true),
        ));
        $menu['Labs']['Lab1']->addChild('Wyniki', array(
            'route' => 'lab1_wynik_index',
            'label' => '<i class="fa fa-bar-chart-o fa-fw"></i> Wyniki',
            'extras' => array('safe_label' => true),
        ));
        $menu['Labs']->addChild('Lab2', array(
            'uri' => '#',
            'label' => '2. Próba statyczna ściskania<span class="fa arrow"></span>',
            'extras' => array('safe_label' => true),
        ));
        $menu['Labs']['Lab2']->setChildrenAttribute('class', 'nav nav-third-level');
        $menu['Labs']['Lab2']->addChild('Pomiary', array(
            'route' => 'lab2_pomiar_index',
            'label' => '<i class="fa fa-edit fa-fw"></i> Pomiary',
            'extras' => array('safe_label' => true),
        ));
        $menu['Labs']['Lab2']->addChild('Wyniki', array(
            'route' => 'lab2_wynik_index',
            'label' => '<i class="fa fa-bar-chart-o fa-fw"></i> Wyniki',
            'extras' => array('safe_label' => true),
        ));

//        $securityContext = $this->get('security.authorization_checker');
//        if($securityContext->isGranted('ROLE_ADMIN')) {

            $menu->addChild(
                'Dashboard',
                array(
                    'uri' => '#',
                    'label' => '<i class="fa fa-dashboard fa-fw"></i> Kokpit',
                    'extras' => array('safe_label' => true),
                )
            );
            $menu->addChild(
                'Settings',
                array(
                    'uri' => '#',
                    'label' => '<i class="fa fa-wrench fa-fw"></i> Ustawienia',
                    'extras' => array('safe_label' => true),
                )
            );
//        }
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
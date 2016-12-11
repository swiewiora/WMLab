<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'index'));
        $menu->addChild('Laboratorium 1');
        $menu['Laboratorium 1']->addChild('Pomiary', array('route' => 'lab1_pomiar_index'));
        $menu['Laboratorium 1']->addChild('Wyniki', array('route' => 'lab1_wynik_index'));


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
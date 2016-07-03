<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Knp\Menu\ItemInterface;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function main(FactoryInterface $factory, array $options)
    {
        $main = $factory->createItem('root');
        
        // End result
        // $main->addChild('Layout',array('route' => 'menu_index'));
        // $main['Layout']->addChild('Node',array('route' => 'menu_index'));
        // $main['Layout']['Node']->addChild('Slider',array('route' => 'menu_index'));

        $em = $this->container->get('doctrine')->getManager();

        $menus = $em->getRepository('AppBundle:Menu')->findAll();

        return $main;
    }
}

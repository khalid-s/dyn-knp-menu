<?php

namespace IKNSA\CMSBundle\MenuBundle\Menu;

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
        
        $em = $this->container->get('doctrine')->getManager();

        $menus = $em->getRepository('IKNSACMSBundleMenuBundle:Menu')->getMenusOrderByLevel();

        return $main;
    }

    public function getName($menuItem)
    {
        return $menuItem->getName();
    }

    public function getOptions()
    {
    }

    public function getChildren($menuItem)
    {
        return $menuItem->getChildren();
    }
}

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
        // $what = $main->addChild('Layout',array('route' => 'menu_index'));
        // // var_dump($what);
        // $what->addChild('Node',array('route' => 'menu_index'));
        // $main['Layout']['Node']->addChild('Slider',array('route' => 'menu_index'));

        $em = $this->container->get('doctrine')->getManager();

        $dataEntries = $em->getRepository('AppBundle:Menu')->findAll();

        // Loop over each menu entry
        foreach ($dataEntries as $dataEntry) {
            // Handle only the parents in this loop
            if (null !== $dataEntry->getParent()) continue;
            $parentKnpEntry = $main->addChild($dataEntry->getName(), ['route' => 'menu_index']);

            // Call a recursive function to bind childrens to their parent.
            $this->bindChildrensToParent($dataEntry, $parentKnpEntry);
        }


        return $main;
    }

    /**
     * Recursively binds childs to their parent
     *
     * @param  $dataEntry  - An instance of entity Menu
     * @param  $knpEntry   - A reference to a "knp entry" (returned by the "addChild" method)
     */

    private function bindChildrensToParent($dataEntry, $knpEntry) {
        $childrens = $dataEntry->getChildren();
        if (0 === count($childrens)) return;

        foreach ($childrens as $child) {
            $childKnpEntry = $knpEntry->addChild($child->getName(), ['route' => 'menu_index']);
            $this->bindChildrensToParent($child, $childKnpEntry);
        }
    }
}

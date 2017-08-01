<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月5日
*/
namespace ManageBundle\EventListener;

use CoreBundle\Services\ServiceBase;
use Symfony\Component\HttpFoundation\Request;
use Avanzu\AdminThemeBundle\Model\MenuItemModel;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MenuItemListListener extends ServiceBase
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }
    }
    
    protected function getMenu(Request $request)
    {
        $rootItems = $this->get('db.menus')->getMenuTree();

        return $this->activateByRoute($request, $rootItems);
    }
    
    protected function activateByRoute($request, $items)
    {
    
        foreach($items as $item) { /** @var $item MenuItemModel */
            if($item->hasChildren())
                $this->activateByRoute($request, $item->getChildren());
            elseif($item->getRoute() == $request->getRequestUri())
                $item->setIsActive(true);
        }
    
        return $items;
    }
}
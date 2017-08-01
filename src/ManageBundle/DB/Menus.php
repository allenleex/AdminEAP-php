<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年07月26日
*/
namespace ManageBundle\DB;

use CoreBundle\Services\AbstractServiceManager;
use Avanzu\AdminThemeBundle\Model\MenuItemModel;

/**
* 菜单表
* 
*/
class Menus extends AbstractServiceManager
{
    public function getMenuTree($ishide=false)
    {        
        $map = array();
        
        if($ishide)
        {
            $map['is_hide'] = 0;
            $map['status'] = 1;
        }

        parent::_handleMap($map);

        $result = parent::findBy($map, null, 500);

        $result = self::_getMenuTree(isset($result['rows'])?$result['rows']:array());

        return $result;
    }
    
    private function _getMenuTree(array $menus, $pid=0)
    {
        $tree = array();
        $menuList = array();
        $menuobjs = array();
        $notrootmenu = array();
        
        //取最小id
        if($pid==0)
        {
            $ppid = 99999999;
            foreach($menus as $menu)
            {
                if(is_object($menu))
                {
                    $mpid = $menu->getPid();
                    $menuList[$menu->getId()] = $menu;
                }else{
                    $mpid = $menu['pid'];
                    $menuList[$menu['id']] = $menu;
                }
        
                if($mpid<$ppid)
                {
                    $ppid = $mpid;
                    $pid = $mpid;
                }        
            }
        }

        //循环
        foreach($menus as $menu)
        {
            $earg = array();
            $route = $menu->getRoute();
            
            if(empty($route)&&$menu->getController())
            {
                $route = $menu->getBundle()."/".$menu->getController()."/";
                
                $route .= $menu->getAction()?$menu->getAction():'index';
            }
            $route = $route?$this->get('core.common')->U($route):$route;
             
            $menuobj = new MenuItemModel($menu->getId(), $menu->getLabel(), $route, $earg, $menu->getIcon());

            if(isset($menuList[$menu->getPid()]))
                $menuobj->setParent(new MenuItemModel($menuList[$menu->getPid()]->getId(), $menuList[$menu->getPid()]->getLabel(), '', $earg, $menuList[$menu->getPid()]->getIcon()));
                
            $menuobjs[$menu->getId()] = $menuobj;
        
            $mpid = $menu->getPid();
            //根目录
            if ($pid==$mpid)
                $tree[$menu->getId()] = $menuobj;
            else
                $notrootmenu[$menu->getId()]=$menuobj;
        }
        
        foreach($notrootmenu as $menuobj)
        {
            if($menuobj->hasParent()&&isset($menuobjs[$menuobj->getParent()->getIdentifier()]))
            {
                $menuobjs[$menuobj->getParent()->getIdentifier()]->addChild($menuobj);
            }
        }
        
        unset($pid);
        unset($ppid);
        unset($mpid);
        unset($menus);
        unset($menuList);
        unset($menuobjs);
        unset($notrootmenu);

        return $tree;
    }
}
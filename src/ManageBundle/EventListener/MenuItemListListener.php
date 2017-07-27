<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月5日
*/
namespace ManageBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Avanzu\AdminThemeBundle\Model\MenuItemModel;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;

class MenuItemListListener
{
    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }
    }
    
    protected function getMenu(Request $request)
    {
        //url参数
        $earg      = array();
        $rootItems = array(
            $webset = new MenuItemModel('webset', '网站设置', '', $earg, 'fa fa-bank')
            ,$sysset = new MenuItemModel('sysset', '系统设置', '', $earg, 'fa fa-laptop')
            ,$userset = new MenuItemModel('userset', '用户设置', '', $earg, 'fa fa-laptop')
        );
        
        //二级目录
        $webset->addChild(new MenuItemModel('setsite', '站点设置', 'manage_setsite', $earg, 'fa fa-pie-chart'));
        $webset->addChild(new MenuItemModel('setwifi', '微Winfi', 'manage_setwifi', $earg, 'fa fa-edit'));
        
        //系统设置
        $sysset->addChild(new MenuItemModel('setbundle', '设置Bundle', 'manage_setbundle', $earg, 'fa fa-suitcase'));
        $sysset->addChild(new MenuItemModel('setmodels', '设置模型', 'manage_setmodels', $earg, 'fa fa-train'));
        $sysset->addChild(new MenuItemModel('setmodelform', '设置表单', 'manage_setmodelform', $earg, 'fa fa-university'));
        $sysset->addChild(new MenuItemModel('setcontroller', '设置控制器', 'manage_setcontroller', $earg, 'fa fa-trophy'));
        $sysset->addChild(new MenuItemModel('setmenus', '设置菜单', 'manage_setmenus', $earg, 'fa fa-black-tie'));
        $sysset->addChild(new MenuItemModel('setroutes', '设置路由', 'manage_setroutes', $earg, 'fa fa-gg'));
        $sysset->addChild(new MenuItemModel('setthemes', '设置主题', 'manage_setthemes', $earg, 'fa fa-safari'));
        
        //用户设置
        $userset->addChild(new MenuItemModel('setuser', '用户管理', 'manage_setuser', $earg, 'fa fa-user'));
        $userset->addChild(new MenuItemModel('setgroup', '组织管理', 'manage_setgroup', $earg, 'fa fa-sitemap'));
        $userset->addChild(new MenuItemModel('setfunc', '功能管理', 'manage_setfunc', $earg, 'fa fa-cog'));
        $userset->addChild(new MenuItemModel('setrole', '角色管理', 'manage_setrole', $earg, 'fa fa-street-view'));
        $userset->addChild(new MenuItemModel('setauthorize', '用户授权', 'manage_setauthorize', $earg, 'fa fa-key'));
        $userset->addChild(new MenuItemModel('setdictionaries', '字典管理', 'manage_setdictionaries', $earg, 'fa fa-book'));
        $userset->addChild(new MenuItemModel('setuserdemo', '用户管理DEMO', 'manage_setuserdemo', $earg, 'fa fa-user'));
        
        return $this->activateByRoute($request->get('_route'), $rootItems);
    }

    protected function getMenuback(Request $request)
    {
        //url参数
        $earg      = array();
        $rootItems = array(
            new MenuItemModel('dashboard', '系统管理', 'avanzu_admin_dash_demo', $earg, 'fa fa-dashboard', 'newss'),
            $ui = new MenuItemModel('ui-elements', 'UI管理', '', $earg, 'fa fa-laptop'),
            $us = new MenuItemModel('us-elements', 'Us管理', '', $earg, 'fa fa-laptop')
        );
    
        $ui->addChild(new MenuItemModel('ui-elements-general', '普通', 'avanzu_admin_ui_gen_demo', $earg, 'fa fa-pie-chart', 'new'))
        ->addChild(new MenuItemModel('ui-elements-icons', '图标', 'avanzu_admin_ui_icon_demo', $earg, 'fa fa-th'));

        $us->addChild($icons = new MenuItemModel('us-elements-general', 'Generals', 'avanzu_admin_ui_gen_demo', $earg, 'new'));

        $icons->addChild(new MenuItemModel('widgets', 'Widgets', 'avanzu_admin_demo', $earg, 'fa fa-th', 'new'));
        $icons->addChild(new MenuItemModel('forms', 'Forms', 'avanzu_admin_form_demo', $earg, 'fa fa-edit'));

        return $this->activateByRoute($request->get('_route'), $rootItems);
    
    }
    
    protected function activateByRoute($route, $items)
    {
    
        foreach($items as $item) { /** @var $item MenuItemModel */
            if($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            }
            else {
                if($item->getRoute() == $route) {
                    $item->setIsActive(true);
                }
            }
        }
    
        return $items;
    }
}
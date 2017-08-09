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
    protected $stag, $filePath;
    
    public function _initialize()
    {
        $className = strtolower(parent::get_class_name());

        //缓存标识,以数据库名称区别
        $this->stag = $this->get('core.common')->C('database_name')."_".$className;
    
        $this->filePath = $this->get('core.common')->getSiteRoot()."FileDB".DIRECTORY_SEPARATOR."config_".$className.".yml";
    }
    
    /**
     * 添加
     * @param array $data
     * @return int id
     */
    public function add(array $data, \stdClass $info=null, $isValid=true)
    {
        return self::handleYmlData(parent::add($data, $info, $isValid));
    }
    
    /**
     * 更新
     * @param int	$id		基于ID的更新条件
     * @param array $data	更新的参数
     * @return bool
     */
    public function update($id, array $data, $info=null, $isValid=true)
    {
        return self::handleYmlData(parent::update($id, $data, $info, $isValid));
    }

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
    
    public function handleYmlData($data)
    {
        $result = array();
        $map = array();
        $map['status'] = 1;
        $map['order'] = 'sort|asc,id|asc';
        $info = parent::findBy($map, null, 10000);
    
        if(isset($info['rows']))
        {
            foreach($info['rows'] as $item)
            {
                $result['id'][$item->getId()]['name'] = $item->getName();
                $result['id'][$item->getId()]['label'] = $item->getLabel();
                $result['id'][$item->getId()]['route'] = $item->getRoute();
                $result['id'][$item->getId()]['icon'] = $item->getIcon();
                $result['id'][$item->getId()]['badge'] = $item->getBadge();
                $result['id'][$item->getId()]['routeArgs'] = $item->getRouteArgs();
                $result['id'][$item->getId()]['badgeColor'] = $item->getBadgeColor();
                $result['id'][$item->getId()]['pid'] = $item->getPid();
                $result['id'][$item->getId()]['bundle'] = $item->getBundle();
                $result['id'][$item->getId()]['controller'] = $item->getController();                
                $result['id'][$item->getId()]['action'] = $item->getAction();
                $result['id'][$item->getId()]['is_hide'] = $item->getIsHide();
                
                $result['bundle'][$item->getId()]['id'] = $item->getId();
                $result['bundle'][$item->getId()]['name'] = $item->getName();
                $result['bundle'][$item->getId()]['label'] = $item->getLabel();
                $result['bundle'][$item->getId()]['route'] = $item->getRoute();
                $result['bundle'][$item->getId()]['icon'] = $item->getIcon();
                $result['bundle'][$item->getId()]['badge'] = $item->getBadge();
                $result['bundle'][$item->getId()]['routeArgs'] = $item->getRouteArgs();
                $result['bundle'][$item->getId()]['badgeColor'] = $item->getBadgeColor();
                $result['bundle'][$item->getId()]['pid'] = $item->getPid();
                $result['bundle'][$item->getId()]['bundle'] = $item->getBundle();
                $result['bundle'][$item->getId()]['controller'] = $item->getController();
                $result['bundle'][$item->getId()]['action'] = $item->getAction();
                $result['bundle'][$item->getId()]['is_hide'] = $item->getIsHide();
            }
        }
    
        $this->get('core.ymlParser')->ymlWrite($result, $this->filePath);
    
        unset($info);
    
        //重置缓存
        $this->get('core.common')->S($this->stag, $result, 86400);
    
        unset($info);
        unset($result);
        return $data;
    }
    
    /**
     * 直接从文件中读取
     * @param array $criteria
     * @return multitype:
     */
    public function getData($str, $flag=null)
    {
        $info = $this->get('core.common')->S($this->stag);
    
        if(empty($info))
        {
            $info = $this->get('core.ymlParser')->ymlRead($this->filePath);
    
            $this->get('core.common')->S($this->stag, $info, 86400);
        }
        if(empty($info))
            return array();
    
        switch($flag)
        {
            case 'bundle':
                $info = isset($info['bundle'])?$info['bundle']:array();
                break;
            default:
                $info = isset($info['id'])?$info['id']:array();
                break;
        }
    
        return isset($info[$str])?$info[$str]:array();
    }
}
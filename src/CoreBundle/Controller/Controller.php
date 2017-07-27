<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月3日
*/
namespace CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Avanzu\AdminThemeBundle\Event\ThemeEvents;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use CoreBundle\Security\TokenAuthenticatedInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller AS SymfonyController;

class Controller extends SymfonyController implements TokenAuthenticatedInterface
{
    protected $parameters = array();

    /**
     * 架构函数 取得模板对象实例
     * @access public
     */
    public function __construct()
    {
        //控制器初始化
        if(method_exists($this,'_initialize'))
            $this->_initialize();
    }

    public function render($bundle=null, array $parameters = array(), Response $response = null)
    {
        $bundle = $bundle?$bundle:self::getBundleName();
    
        //加载一些初始化的参数
        self::getInitInfo();
    
        //组装模版路径
        $template = self::getTemplate($bundle).':'.ucfirst(self::getControllerName()).':'.self::getActionName().'.html.twig';
    
        if (!$this->get('templating')->exists($template))
            throw new \Exception("没有发现模版文件:【".$template."】", 403);
    
        return parent::render($template, $this->parameters, $response);
    }

    public function render1($template, array $parameters = array(), Response $response = null)
    {
        //加载一些初始化的参数
        self::getInitInfo();
    
        if (!$this->get('templating')->exists($template))
            throw new \Exception("没有发现模版文件:【".$template."】", 403);
    
        return parent::render($template, $this->parameters, $response);
    }

    /**
     * 获得所有的已加载Bundle
     */
    public function getBundles()
    {
        return $this->get('core.common')->getBundles();
    }

    /**
     * 获得当前路由的bundle名称
     */
    final protected function getBundleName()
    {
        return $this->get('core.common')->getBundleName();
    }

    /**
     * 获得当前路由的控制器名称
     */
    final protected function getControllerName()
    {
        return $this->get('core.common')->getControllerName();
    }

    /**
     * 获得当前路由的动作名称
     */
    final protected function getActionName()
    {
        return $this->get('core.common')->getActionName();
    }

    /**
     * 初始化信息
     */
    final public function getInitInfo($template=null)
    {
        $this->parameters['corepath'] = isset($this->parameters['corepath'])?$this->parameters['corepath']:"bundles/core";
        $this->parameters['csrf_token'] = isset($this->parameters['csrf_token'])?$this->parameters['csrf_token']:$this->createCsrfToken();
        $this->parameters['version'] = isset($this->parameters['version'])?$this->parameters['version']:"";
        $this->parameters['copyright'] = isset($this->parameters['copyright'])?$this->parameters['copyright']:"东莞鼎点科技";
        $this->parameters['product'] = isset($this->parameters['product'])?$this->parameters['product']:"08CMS";
        $this->parameters['keyword'] = isset($this->parameters['keyword'])?$this->parameters['keyword']:"08CMS";
        $this->parameters['content'] = isset($this->parameters['content'])?$this->parameters['content']:"";
        $this->parameters['bundle'] = strtolower(substr((self::getBundleName()),0,-6));
        $this->parameters['bundles'] = isset($this->parameters['bundles'])?$this->parameters['bundles']:self::getBundles();
        $this->parameters['bundlename'] = isset($this->parameters['bundlename'])?$this->parameters['bundlename']:self::getBundleName();
        $this->parameters['bundlepath'] = isset($this->parameters['bundlepath'])?$this->parameters['bundlepath']:"bundles/".strtolower(substr($this->parameters['bundlename'],0,-6));
        $this->parameters['bundlejs']   = $this->parameters['bundlepath']."/js";
        $this->parameters['bundlecss']  = $this->parameters['bundlepath']."/css";
        $this->parameters['bundleimages'] = $this->parameters['bundlepath']."/images";
        $this->parameters['controller'] = isset($this->parameters['controller'])?$this->parameters['controller']:self::getControllerName();
        $this->parameters['action'] = isset($this->parameters['action'])?$this->parameters['action']:self::getActionName();
        $this->parameters['rolename'] = isset($this->parameters['rolename'])?$this->parameters['rolename']:(method_exists($this->getUser(), 'getRoleName')?$this->getUser()->getRoleName():"游客");
        
        if (!$this->getDispatcher()->hasListeners(ThemeEvents::THEME_BREADCRUMB)) {
            return new Response();
        }
        
        $active = $this->getDispatcher()->dispatch(ThemeEvents::THEME_BREADCRUMB,new SidebarMenuEvent($this->get('request')))->getActive();
        /** @var $active MenuItemInterface */
        $list = array();
        
        if($active) {
        
            $list[] = $active;
            while(null !== ($item = $active->getActiveChild())) {
                $list[] = $item;
                $active = $item;
            }
        }
        
        $this->parameters['active'] = $list;
        $this->parameters['title'] = is_object($active)?$active->getLabel():'';
    
    }
    
    /**
     * @return EventDispatcher
     */
    protected function getDispatcher()
    {
        return $this->get('event_dispatcher');
    }

    final protected function getTemplate($bundle)
    {
        return $bundle;
        $usertplid = $bundle;
        //判断手机浏览器
        if($this->get('core.common')->isMobileClient())
        {
            //去掉bundle后缀
            if (preg_match('/Bundle$/', $bundle))
                $usertplid = substr($bundle, 0, -6)."mobileBundle";
    
            //如果手机模版不存在则使用模认的手机模版
            if(!$this->get('templating')->exists($usertplid.':'.ucfirst($this->getControllerName()).':'.$this->getActionName().'.html.twig'))
            {
                $usertplid = $bundle;
    
                //如果默认主题模版不存在则用PC主题
                if(!$this->get('templating')->exists($usertplid.':'.ucfirst($this->getControllerName()).':'.$this->getActionName().'.html.twig'))
                    $usertplid = self::getBundleName();
            }
        }elseif($usertplid!=$this->getBundleName()&&$this->has('db.auth_theme')){
            $map = array();
            $map['bundle'] = $this->getBundleName();
            $map['controller'] = $this->getControllerName();
            $map['action'] = $this->getActionName();
            $count = $this->get('db.auth_theme')->count($map);
            if($count > 0)
                $usertplid = $this->getBundleName();
        }
    
        return $usertplid;
    }

    /**
     * 根据路由参数创建csrf
     * @return csrf
     */
    protected function createCsrfToken()
    {
        $user = parent::getUser();
    
        //返回csrf值
        $tokenInfo = $this->get('security.csrf.token_manager')->getToken(method_exists($user, 'getId')?$user->getId():0);
    
        return $tokenInfo->getValue();
    }
    
    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param string $message 提示信息
     * @param string $jumpUrl 页面跳转地址
     * @param Boolean|array $ajax 是否为Ajax方式
     * @return void
     */
    final protected function success($message, $jumpUrl='', $paramet=array(), $ajax=false)
    {
        return $this->get('core.common')->showMessage($message, 1, is_array($paramet)?$paramet:array(), $jumpUrl, $ajax);
    }
    
    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param string $message 错误信息
     * @param string $jumpUrl 页面跳转地址
     * @param Boolean|array $ajax 是否为Ajax方式
     * @return void
     */
    final protected function error($message, $jumpUrl='', $ajax=false)
    {
        return $this->get('core.common')->showMessage($message, 0, array(), $jumpUrl, $ajax);
    }

    protected function get($id)
    {
        /**
         * 兼容3.0之前的版本request服务
         */
        if($id=='request')
            return $this->container->get('request_stack')->getCurrentRequest();
    
        if (!$this->container->has($id))
            throw new \InvalidArgumentException("[".$id."]服务未注册。");
    
        return parent::get($id);
    }

    protected function _empty($method,$args)
    {
        return self::error(sprintf('[ %s ]方法不存在', $method));
    }
}
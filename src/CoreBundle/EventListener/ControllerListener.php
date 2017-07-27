<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年2月22日
*/
namespace CoreBundle\EventListener;

use CoreBundle\Services\ServiceBase;
use Symfony\Component\HttpFoundation\Response;
use CoreBundle\Security\TokenAuthenticatedInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class ControllerListener extends ServiceBase
{
    private $tokens;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->tokens = array();
    }
    
    /**
     * 前置
     * @param FilterControllerEvent $event
     * @throws AccessDeniedHttpException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        //判断是否主请求
        if(!$event->isMasterRequest())
            return;

        $controller = $event->getController();
        
        //判断是否正常路由过来的
        if (!is_array($controller))
            return;

        //判断控制器是否属 TokenAuthenticatedInterface 实例
        if ($controller[0] instanceof TokenAuthenticatedInterface)
        {
            $token = $event->getRequest()->query->get('token');

            if ($token&&!in_array($token, $this->tokens)) {
                throw new AccessDeniedHttpException('This action needs a valid token!');
            }

            // mark the request as having passed token authentication
            $event->getRequest()->attributes->set('auth_token', 'test08cms');
        }
    }
    
    /**
     * 后置
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        //判断是否主请求
        if(!$event->isMasterRequest())
            return;
        //dump($event);die();
        // check to see if onKernelController marked this as a token "auth'ed" request
        if (!$token = $event->getRequest()->attributes->get('auth_token'))
            return;
        
        $response = $event->getResponse();
        
        // create a hash and set it as a response header
        $hash = sha1($response->getContent().$token);

        $response->headers->set('X-CONTENT-HASH', $hash);
    }
    
    /**
     * 模版
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();
        
        if (!isset($result['template']) || empty($result['template']) || !isset($result['data']))
            return;
        
        self::getTemplateConf($result);

        $event->setResponse(new Response($this->get('twig')->render($result['template'], $result['data'])));
    }
    
    /**
     * 请求
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        //判断是否主请求
        //if(!$event->isMasterRequest())
        //    return;
        
//         dump($event);
//         dump($this->get('twig')->getGlobals());

//         $this->get('twig')->addGlobal('myvar', 'abcdef');

    }
    
    /**
     * 异常抛出
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        //判断是否主请求
        if(!$event->isMasterRequest())
            return;
    }
    
    /**
     * 获取模版数据
     * @param string $template
     */
    protected function getTemplateConf(&$result)
    {
        //初始化参数
        $usertplid = "";
        $template = $result['template'];
        
        $user = $this->get('core.common')->getUser();
        
        //获取用户主题 
        if(method_exists($user, 'getUsertplid'))
            $usertplid = $user->getUsertplid();
        
        //数据标识路径
        $filePath = $this->get('core.common')->getIdentPath($this->get('core.common')->getBundleName());
        
        //bundle标识路径
        $bidentPath = $filePath."index.yml";
        
        //控制器标识
        $cidentPath = $filePath.ucfirst($this->get('core.common')->getControllerName()).DIRECTORY_SEPARATOR."Index".DIRECTORY_SEPARATOR."index.yml";

        //创建bundle标识路径(无则创建，有则跳过)
        $this->get('core.ident')->createYmlFile($bidentPath);
        
        //创建控制器标识(无则创建，有则跳过)
        $this->get('core.ident')->createYmlFile($cidentPath);
        
        $result['data']['corepath'] = 'bundles/core';
        $result['data']['csrf_token'] = $this->get('core.common')->createCsrfToken();
        $result['data']['version'] = $this->container->getParameter('_version');
        $result['data']['company'] = $this->container->getParameter('_copyright');
        $result['data']['product'] = $this->container->getParameter('_sitename');
        $result['data']['keyword'] = $this->container->getParameter('_keyword');
        $result['data']['content'] = $this->container->getParameter('_content');
        $result['data']['bundles'] = $this->get('core.common')->getBundles();
        $result['data']['bundlename'] = $this->get('core.common')->getBundleName();
        $result['data']['bundlepath'] = strtolower(substr($result['data']['bundlename'],0,-6));
        $result['data']['themespath'] = $usertplid?strtolower(substr($usertplid,0,-6)):strtolower(substr($result['data']['bundlename'],0,-6));
        $result['data']['controller'] = $this->get('core.common')->getControllerName();
        $result['data']['action'] = $this->get('core.common')->getActionName();
        $result['data']['rolename'] = method_exists($user, 'getRoleName')?$user->getRoleName():"游客";
        $result['data']['url'] = $this->get('request')->server->get('HTTP_REFERER');
        $result['data']['ident'] = array();//$this->get('core.ident')->findTemplateYml($template);
        $result['data']['bident'] = array();//$this->get('core.ident')->findTemplateYml($template, $bidentPath);
        $result['data']['cident'] = array();//$this->get('core.ident')->findTemplateYml($template, $cidentPath);

        
        dump($template,$filePath);die();
    }
}
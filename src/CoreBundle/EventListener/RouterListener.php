<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年2月23日
*/
namespace CoreBundle\EventListener;

use CoreBundle\Services\ServiceBase;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

/**
 * 路径监听
 * @author Administrator
 *
 */
class RouterListener extends ServiceBase
{
    protected $matcher;
    protected $context;
    protected $requestStack;
    protected $logger;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->matcher = $this->get('router');
        $this->context = $this->get('router.request_context');
        $this->requestStack = $this->get('request_stack');
        $this->logger = $this->get('logger');
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        //判断是否配置过控制器
        if ($event->getRequest()->attributes->has('_controller'))
            return;
        
        try {
            if ($this->matcher instanceof RequestMatcherInterface)
                $parameters = $this->matcher->matchRequest($event->getRequest());
            else
                $parameters = $this->matcher->match($event->getRequest()->getPathInfo());

            if (null !== $this->logger) {
                $this->logger->info('Matched route "{route}".', array(
                    'route' => isset($parameters['_route']) ? $parameters['_route'] : 'n/a',
                    'route_parameters' => $parameters,
                    'request_uri' => $event->getRequest()->getUri(),
                    'method' => $event->getRequest()->getMethod(),
                ));
            }

            $event->getRequest()->attributes->add($parameters);
            unset($parameters['_route'], $parameters['_controller']);
            $event->getRequest()->attributes->set('_route_params', $parameters);
        } catch (MethodNotAllowedException $e) {
            $message = sprintf('No route found for "%s %s": Method Not Allowed (Allow: %s)', $event->getRequest()->getMethod(), $event->getRequest()->getPathInfo(), implode(', ', $e->getAllowedMethods()));
        
            throw new MethodNotAllowedHttpException($e->getAllowedMethods(), $message, $e);
        } catch (ResourceNotFoundException $e) {

            $pathInfo = explode("/",trim($event->getRequest()->getPathInfo(),"/"));
            
            //过淲调试工具
            if($pathInfo[0]=='_wdt')
                return;
    
            $bundles = array();
            $bundleArr = array();
            foreach($this->container->get('core.common')->getBundles() as $bundle)
            {
                $_item = explode('\\',$bundle);
            
                //去掉最后一个数组
                array_pop($_item);
            
                $bundles[end($_item)] = implode('\\', $_item);
                
                $bundleArr[strtolower(str_replace("Bundle","",end($_item)))] = "";
            }

            //读取默认前缀配置
            $defaultPrefix = $this->get('core.common')->C('defaultprefix');
    
            //加默认前缀
            if(!isset($bundleArr[$pathInfo[0]]))
                array_unshift($pathInfo,$defaultPrefix);
    
            $bundle = (isset($pathInfo[0])&&$pathInfo[0]?ucfirst($pathInfo[0]):ucfirst($defaultPrefix))."Bundle";
            $controller = isset($pathInfo[1])&&$pathInfo[1]?ucfirst($pathInfo[1])."Controller":"IndexController";
            $action = isset($pathInfo[2])&&$pathInfo[2]?strtolower($pathInfo[2])."Action":"indexAction";
            
            if(!isset($bundles[$bundle]))
                throw new \InvalidArgumentException('无效的Bundle:['.$bundle.']');
    
            $controllerpath	= $bundles[$bundle]."\\Controller\\".$controller."::".$action;
            $routepath = (isset($pathInfo[0])?strtolower($pathInfo[0]):$defaultPrefix)."_";
            $routepath .= (isset($pathInfo[1])?strtolower($pathInfo[1]):"index")."_";
            $routepath .= (isset($pathInfo[2])?strtolower($pathInfo[2]):"index");
    
            $parameters = $event->getRequest()->attributes->All();
    
            $parameters['_controller'] = $controllerpath;
            $parameters['_route'] = $routepath;
            $parameters['_b'] = isset($pathInfo[0])&&$pathInfo[0]?strtolower($pathInfo[0]):"index";
            $parameters['_c'] = isset($pathInfo[1])&&$pathInfo[1]?strtolower($pathInfo[1]):"index";
            $parameters['_a'] = isset($pathInfo[2])&&$pathInfo[2]?strtolower($pathInfo[2]):"index";;
            $parameters['exception'] = array();
            $parameters['logger'] = array();
            
            $this->get('logger')->info('Matched route "{route}".', array(
                'route' => isset($parameters['_route']) ? $parameters['_route'] : 'n/a',
                'route_parameters' => $parameters,
                'request_uri' => $event->getRequest()->getUri(),
                'method' => $event->getRequest()->getMethod(),
            ));
            
            //移除路由错误thgj
            //$this->get('logger')->popProcessor();
            $event->getRequest()->attributes->add($parameters);
            
            unset($parameters['_route'], $parameters['_controller']);
            $event->getRequest()->attributes->set('_route_params', array());
        }
    }
    
    public function onKernelRequestback(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        dump($request);die();
        // Don't store subrequests
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }
    
        $request = $event->getRequest();
        $session = $request->getSession();
        $context = $this->router->getContext();
    
        // If current_year exists in session, replace route parameter with it
        if ($session->has('current_year')) {
            $context->setParameter('year', $session->get('current_year'));
        }
        // Else, we set the current year by default
        else {
            $context->setParameter('year', date('Y'));
        }
    
        $routeName = $request->get('_route');
        $routeParams = $request->get('_route_params');
        if ($routeName[0] == "_") {
            return;
        }
        $routeData = ['name' => $routeName, 'params' => $routeParams];
    
        // On ne sauvegarde pas la même route plusieurs fois
        $thisRoute = $session->get('this_route', []);
        if ($thisRoute == $routeData) {
            return;
        }
        $session->set('last_route', $thisRoute);
        $session->set('this_route', $routeData);
    }
}
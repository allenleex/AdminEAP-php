<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年2月22日
*/
namespace CoreBundle\EventSubscriber;

use CoreBundle\Services\ServiceBase;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionSubscriber extends ServiceBase implements EventSubscriberInterface
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array(
            KernelEvents::EXCEPTION => array(
                array('processException', 10),
                array('logException', 0),
                array('notifyException', -10),
            )
        );
    }
    
    public function processException(GetResponseForExceptionEvent $event)
    {
        return true;
        $exception = $event->getException();
        
        $parameters = [];
        $parameters['status'] = false;
        $parameters['code'] = (int)$exception->getCode();
        $parameters['info'] = $exception->getMessage();
        $parameters['url'] = $this->get('router')->generate('core_error', $parameters);
        
        //判断是否为ajax提交
        if($this->get('request')->isXmlHttpRequest())
        {
            $json = new JsonResponse($parameters);
            die($json->getContent());
        }
        
        if($this->get('kernel')->getEnvironment() != "dev")
            return new RedirectResponse($parameters['url']);
    }
    
    public function logException(GetResponseForExceptionEvent $event)
    {
        return true;
        $exception = $event->getException();
        
        $parameters = [];
        $parameters['status'] = false;
        $parameters['code'] = (int)$exception->getCode();
        $parameters['info'] = $exception->getMessage();
        $parameters['url'] = $this->get('router')->generate('core_error', $parameters);
        
        //判断是否为ajax提交
        if($this->get('request')->isXmlHttpRequest())
        {
            $json = new JsonResponse($parameters);
            die($json->getContent());
        }
        
        if($this->get('kernel')->getEnvironment() != "dev")
            return new RedirectResponse($parameters['url']);
    }
    
    public function notifyException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        
        $parameters = [];
        $parameters['status'] = false;
        $parameters['code'] = (int)$exception->getCode();
        $parameters['info'] = $exception->getMessage();
        $parameters['url'] = $this->get('router')->generate('core_error', $parameters);
        
        //判断是否为ajax提交
        if($this->get('request')->isXmlHttpRequest())
        {
            $json = new JsonResponse($parameters);
            die($json->getContent());
        }
        
        if($this->get('kernel')->getEnvironment() != "dev")
            return new RedirectResponse($parameters['url']);
    }
}
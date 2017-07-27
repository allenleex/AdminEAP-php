<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月4日
*/
namespace ManageBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Avanzu\AdminThemeBundle\Event\ThemeEvents;
use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use Avanzu\AdminThemeBundle\Event\TaskListEvent;
use Avanzu\AdminThemeBundle\Event\MessageListEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Avanzu\AdminThemeBundle\Event\NotificationListEvent;

class NavbarController extends Controller
{

    /**
     * @return EventDispatcher
     */
    protected function getDispatcher()
    {
        return $this->get('event_dispatcher');
    }


    public function notificationsAction($max = 5)
    {

        if (!$this->getDispatcher()->hasListeners(ThemeEvents::THEME_NOTIFICATIONS))
            return new Response();


        $listEvent = $this->getDispatcher()->dispatch(ThemeEvents::THEME_NOTIFICATIONS, new NotificationListEvent());
        
        $this->parameters['total'] = $listEvent->getTotal();
        $this->parameters['notifications'] = $listEvent->getNotifications();
        
        return $this->render();
    }

    public function messagesAction($max = 5)
    {

        if (!$this->getDispatcher()->hasListeners(ThemeEvents::THEME_MESSAGES))
            return new Response();


        $listEvent = $this->getDispatcher()->dispatch(ThemeEvents::THEME_MESSAGES, new MessageListEvent());
        
        $this->parameters['total'] = $listEvent->getTotal();
        $this->parameters['messages'] = $listEvent->getMessages();
        
        return $this->render();
    }

    public function tasksAction($max = 5)
    {

        if (!$this->getDispatcher()->hasListeners(ThemeEvents::THEME_TASKS))
            return new Response();

        $listEvent = $this->getDispatcher()->dispatch(ThemeEvents::THEME_TASKS, new TaskListEvent());
        
        $this->parameters['total'] = $listEvent->getTotal();
        $this->parameters['tasks'] = $listEvent->getTasks();
        
        return $this->render();
    }

    public function userAction()
    {

        if (!$this->getDispatcher()->hasListeners(ThemeEvents::THEME_NAVBAR_USER))
            return new Response();
 
        $userEvent = $this->getDispatcher()->dispatch(ThemeEvents::THEME_NAVBAR_USER, new ShowUserEvent());
        
        $this->parameters['user'] = $userEvent->getUser();
        
        return $this->render();
    }

}
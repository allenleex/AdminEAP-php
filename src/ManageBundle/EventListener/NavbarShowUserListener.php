<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月6日
*/
namespace ManageBundle\EventListener;

use Avanzu\AdminThemeBundle\Model\UserModel;
use Avanzu\AdminThemeBundle\Event\ShowUserEvent;


class NavbarShowUserListener 
{
    public function onShowUser(ShowUserEvent $event)
    {
        $user = new UserModel();
        $user->setAvatar('')->setIsOnline(true)->setMemberSince(new \DateTime())->setUsername('Demo User')->setName('house');
    
        $event->setUser($user);
    }
}
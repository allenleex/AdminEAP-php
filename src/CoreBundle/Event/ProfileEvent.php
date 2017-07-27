<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月5日
*/
namespace CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Description of ProfileEvent
 *
 * @author avanzu
 */
class ProfileEvent extends Event
{
    
    protected $user; 
    public function __construct($user)
    {
        $this->user = $user;
    }
    
    
    public function getUser()
    {
        return $this->user;
    }
    
}
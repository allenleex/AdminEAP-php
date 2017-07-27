<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月3日
*/
namespace CoreBundle\Security\Authentication;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class TokenAuthentication extends AbstractToken
{
    public $created;
    public $digest;
    public $nonce;
    
    public function __construct(array $roles = array())
    {
        parent::__construct($roles);
    
        // If the user has roles, consider it authenticated
        $this->setAuthenticated(count($roles) > 0);
    }
    
    public function getCredentials()
    {
        return '';
    }
}
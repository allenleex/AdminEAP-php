<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月3日
*/
namespace CoreBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

class Users implements UserInterface, EquatableInterface 
{
    private $tel;
    private $email;
    private $username;
    private $password;
    private $salt;
    private $locale;
    private $loginip;
    private $token;
    private $isActive;
    private $loginSalt;
    private $roles = array('ROLE_ANONYMOUS');

    public function __construct($user)
    {
        $this->tel = $user->getTel();
        $this->email = $user->getEmail();
        $this->username = $user->getUsername();
        $this->password = md5($user->getPassword());
        $this->salt = md5($user->getSalt());
        $this->locale = $user->getLocale();
        $this->loginip = $user->getLoginip();
        $this->token = $user->getToken();
        $this->isActive = $user->getIsActive();
        $this->loginSalt = $user->getLoginSalt();
    }
    
    public function getRoles()
    {
        return $this->roles;
    }
    
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getSalt()
    {
        return $this->salt;
    }
    
    public function getTel()
    {
        return $this->tel;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function getLocale()
    {
        return $this->locale;
    }
    
    public function getLoginip()
    {
        return $this->loginip;
    }
    
    public function getToken()
    {
        return $this->token;
    }
    
    public function getLoginSalt()
    {
        return $this->loginSalt;
    }
    
    public function eraseCredentials()
    {
        return $this;
    }
    
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof Users)
            return false;
    
        if ($this->password !== $user->getPassword())
            return false;

        if ($this->salt !== $user->getSalt())
            return false;

        if ($this->loginSalt !== $user->getLoginSalt())
            return false;
    
        if ($this->username !== $user->getUsername())
            return false;

        return true;
    }
}
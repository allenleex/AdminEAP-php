<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月5日
*/
namespace CoreBundle\Form\Model;

use ManageBundle\Entity\Users;
use CoreBundle\Manager\UserManager;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of ResetPassword
 *
 * @author avanzu
 */
class ResetPassword
{
    protected $manager; 
    
    protected $user; 
    
    public function __construct(UserManager $manager, Users $user)
    {
        $this->manager = $manager;
        $this->user    = $user;
    }

    /**
     * 
     * @return string
     * @Assert\NotBlank()
     * @Assert\Length(min=6, minMessage="user.password.minlength")
     */
    public function getNewPassword()
    {
        return $this->user->getPlainPassword();
    }

    public function setNewPassword($newPassword)
    {
        $this->user->setPlainPassword($newPassword);
    }

    public function getUser() {
        return $this->user;
    }
}
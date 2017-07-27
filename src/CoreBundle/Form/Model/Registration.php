<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月5日
*/
namespace CoreBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Registration
 *
 * @author avanzu
 */
class Registration
{
    /**
     *
     * @var User 
     * 
     * @Assert\Type(type="ManageBundle\Entity\Users")
     */
    protected $user; 
    /**
     *
     * @var bool
     * @Assert\NotBlank(message="registration.terms.blank")
     * @Assert\True(message="registration.terms.true") 
     */
    protected $termsAccepted;
    
    
    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = $termsAccepted;
    }
}
<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月5日
*/
namespace CoreBundle\Manager;

use ManageBundle\Entity\Users;
use Doctrine\ORM\EntityManager;
use CoreBundle\Event\ProfileEvent;
use CoreBundle\Form\Model\Registration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


/**
 * Description of UserManager
 *
 * @author avanzu
 */
class UserManager
{
    /**
     *
     * @var EntityManager 
     */
    protected $em;
    
    protected $userClass;

    /**
     *
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactory 
     */
    protected $encoderFactory;
    
    
    
    protected $dispatcher;
    function __construct(EntityManagerInterface $em, EventDispatcherInterface $dispatcher, EncoderFactoryInterface $encoder, $userClass)
    {
        $this->em             = $em;
        $this->encoderFactory = $encoder;
        $this->userClass      = $userClass;
        $this->dispatcher     = $dispatcher;
    }
    public function getEncodedPassword($plain, $user)
    {
        $encoder  = $this->encoderFactory->getEncoder($user);
        $password = $encoder->encodePassword($plain, $user->getSalt());
        return $password;
    }
    
    public function encodePassword(Users $user)
    {
        $password = $this->getEncodedPassword($user->getPlainPassword(), $user);
        $user->setPassword($password);
        return $this;
    }

    public function generateToken(Users $user)
    {
        $token = sha1(uniqid($user->getSalt()));
        $user->setConfirmationToken($token);
        return $this;
    }

    public function createUser(Registration $registration)
    {
        $user = $registration->getUser();
        $this->em->beginTransaction();
        try {
            $this->encodePassword($user)->generateToken($user);
            // save the new user
            $this->em->persist($user);
            $this->em->flush();
            
            $event = new ProfileEvent($user);
            $this->dispatcher->dispatch('profile.created', $event);
            
            $this->em->commit();
        }
        catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }
        return true;
    }
    
    public function activateUserByToken($token)
    {
        
        $user = $this->findUserByToken($token);
            
        /*@var $user User */
        $user->setIsActive(true)->setConfirmationToken(null);
        
        $this->em->persist($user);
        
        $this->dispatcher->dispatch('profile.activated', new ProfileEvent($user));
        
        $this->em->flush();
        
        return $user;
    }
    
    public function changePassword($user)
    {
        
        $this->encodePassword($user); 
        $this->em->persist($user); 
        $this->em->flush();
        
    }
 
    public function findUserByNameOrEmail($nameOrEmail)
    {
        return $this->em->getRepository($this->userClass)->loadUserByUsername($nameOrEmail);
    }
    
    public function findUserByToken($token)
    {
        return $this->em->getRepository($this->userClass)->loadUserByToken($token);
    }
    
    public function initializeReset($nameOrEmail)
    {
        
        $user = $this->findUserByNameOrEmail($nameOrEmail);
        $this->generateToken($user);
        $this->em->persist($user);
        $this->dispatcher->dispatch('reset.initialized', new ProfileEvent($user));
        $this->em->flush();
    }
    
    public function resetPassword($user)
    {
        
        $this->changePassword($user); 
        $user->setConfirmationToken(null); 
        
        $this->em->persist($user);
        $this->em->flush();
    }
}
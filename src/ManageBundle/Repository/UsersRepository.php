<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月3日
*/
namespace ManageBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;


class UsersRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
        ->where( 'u.tel = :tel OR u.email = :email OR u.username = :username')
        ->setParameter('tel', $username)
        ->setParameter('email', $username)
        ->setParameter('username', $username)        
        ->getQuery()
        ->getOneOrNullResult();
    }
}
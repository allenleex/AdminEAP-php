<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年3月7日
*/
namespace ManageBundle\Security;

use CoreBundle\Security\User\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\SimpleFormAuthenticatorInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class SimpleAuthenticator implements SimpleFormAuthenticatorInterface 
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        try {

            $user = $userProvider->loadUserByUsername($token->getUsername());

        } catch (UsernameNotFoundException $e) {

            throw new CustomUserMessageAuthenticationException('Invalid username or password');

        }

        $passwordValid = $this->encoder->isPasswordValid($user, $token->getCredentials(), $user->getSalt());
    
        if ($passwordValid)
        {
            //设置随机登陆salt
            $str = uniqid(mt_rand(),1);
            $user->setLastLogin(time());
            $user->setLoginIp($_SERVER['REMOTE_ADDR']);
            $user->setLoginSalt(substr(sha1(sha1($str)), 0, 10));

            $user = new Users($user);

            $token = new UsernamePasswordToken(
                $user,
                $user->getPassword(),
                $providerKey,
                $user->getRoles()
            );

            return $token;
        }

        throw new CustomUserMessageAuthenticationException('Invalid username or password');
    }
    
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof UsernamePasswordToken
        && $token->getProviderKey() === $providerKey;
    }
    
    public function createToken(Request $request, $username, $password, $providerKey)
    {
        return new UsernamePasswordToken($username, $password, $providerKey);
    }
}
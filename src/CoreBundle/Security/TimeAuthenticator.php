<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月3日
*/
namespace CoreBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\SimpleFormAuthenticatorInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class TimeAuthenticator implements SimpleFormAuthenticatorInterface 
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
            // CAUTION: this message will be returned to the client
            // (so don't put any un-trusted messages / error strings here)
            throw new CustomUserMessageAuthenticationException('Invalid username or password');
        }
    
        $passwordValid = $this->encoder->isPasswordValid($user, $token->getCredentials());
    
        if ($passwordValid) {
            $currentHour = date('G');
            if ($currentHour < 14 || $currentHour > 16) {
                // CAUTION: this message will be returned to the client
                // (so don't put any un-trusted messages / error strings here)
                throw new CustomUserMessageAuthenticationException(
                    'You can only log in between 2 and 4!',
                    412 // HTTP 412 Precondition Failed
                );
            }
    
            return new UsernamePasswordToken(
                $user,
                $user->getPassword(),
                $providerKey,
                $user->getRoles()
            );
        }
    
        // CAUTION: this message will be returned to the client
        // (so don't put any un-trusted messages / error strings here)
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
<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年3月17日
*/
namespace ManageBundle\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;


class AuthenticationHandler implements AuthenticationSuccessHandlerInterface,  AuthenticationFailureHandlerInterface
{
    protected $router, $doctrine;
    
    public function __construct(Router $router, Doctrine $doctrine)
    {
        $this->router = $router;
        $this->doctrine = $doctrine;
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        //更新用户信息
        $em = $this->doctrine->getManager();
        $repository = $em->getRepository('CoreBundle:Users');
        $user = $repository->loadUserByUsername($token->getUsername());

        $em->persist($user);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            
            //ajax请求
            return new JsonResponse([
                'status' => true,
                'code'    => 0,
                'info' => '登入成功',
                'url' => $this->router->generate('manage_main'),
            ]);
        }
    
        return new RedirectResponse($this->router->generate('manage_main'));
    }
    
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $parameters = [];
        $parameters['status'] = false;
        $parameters['code'] = $exception->getCode();
        $parameters['info'] = $exception->getMessage();

        if ($request->isXmlHttpRequest())
            return new JsonResponse($parameters);

        unset($parameters['status']);
        return new RedirectResponse($this->router->generate('core_error', $parameters));
    }
}
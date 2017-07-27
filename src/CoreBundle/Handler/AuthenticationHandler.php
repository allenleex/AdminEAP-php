<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年3月17日
*/
namespace CoreBundle\Handler;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;


class AuthenticationHandler implements AuthenticationSuccessHandlerInterface,  AuthenticationFailureHandlerInterface
{
    protected $router, $doctrine;
    
    public function __construct(UrlGeneratorInterface $router, ManagerRegistry $doctrine)
    {
        $this->router = $router;
        $this->doctrine = $doctrine;
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        //更新用户信息
        $em = $this->doctrine->getManager();
        $repository = $em->getRepository('CoreCoreBundle:Users');
        $user = $repository->findOneByUsername($token->getUsername());
        $em->persist($user);
        $em->flush();

        
//         $visit = new Visit();
//         $visit->setFormat($request->request->get('_format', 'none'));
//         $visit->setClientIp($request->request->get('client-ip', '0.0.0.0'));
//         $visit->setStatus(Visit::SUCCESS);
        
//         // ...
//         $user->addVisit($visit);
        
//         $em->persist($visit);
//         $em->flush();
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
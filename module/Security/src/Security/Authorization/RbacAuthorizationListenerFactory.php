<?php


namespace Security\Authorization;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RbacAuthorizationListenerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @throws \ZF\OAuth2\Controller\Exception\RuntimeException
     * @return RbacAuthorizationListener
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $userManager = $services->get('Security\OAuth\Manager\UserManager');

        return new RbacAuthorizationListener($userManager);
    }
}

<?php


namespace Security\OAuth\Factory;

use Security\OAuth\Manager\AuthorizationCodeManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthorizationCodeManagerFactory extends AbstractManagerFactory
{
    /**
     * @param ServiceLocatorInterface $services
     * @param array                   $config
     * @return AuthorizationCodeManager
     */
    protected function getManager(ServiceLocatorInterface $services, array $config)
    {
        $objectManager = $this->getObjectManager($services, $config);
        $objectRepository = $this->getObjectRepository($objectManager, 'Security\Entity\OAuth\AuthorizationCode');

        return new AuthorizationCodeManager($objectManager, $objectRepository);
    }
}

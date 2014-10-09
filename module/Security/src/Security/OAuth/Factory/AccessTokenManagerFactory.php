<?php


namespace Security\OAuth\Factory;

use Security\OAuth\Manager\AccessTokenManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class AccessTokenManagerFactory extends AbstractManagerFactory
{
    /**
     * @param ServiceLocatorInterface $services
     * @param array                   $config
     * @return AccessTokenManager
     */
    protected function getManager(ServiceLocatorInterface $services, array $config)
    {
        $objectManager = $this->getObjectManager($services, $config);
        $objectRepository = $this->getObjectRepository($objectManager, 'Security\Entity\OAuth\AccessToken');

        return new AccessTokenManager($objectManager, $objectRepository);
    }
}

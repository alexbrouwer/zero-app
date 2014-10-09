<?php


namespace Security\OAuth\Factory;

use Security\OAuth\Manager\RefreshTokenManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class RefreshTokenManagerFactory extends AbstractManagerFactory
{
    /**
     * @param ServiceLocatorInterface $services
     * @param array                   $config
     * @return RefreshTokenManager
     */
    protected function getManager(ServiceLocatorInterface $services, array $config)
    {
        $objectManager = $this->getObjectManager($services, $config);
        $objectRepository = $this->getObjectRepository($objectManager, 'Security\Entity\OAuth\RefreshToken');

        return new RefreshTokenManager($objectManager, $objectRepository);
    }
}

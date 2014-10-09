<?php


namespace Security\OAuth\Factory;

use Security\OAuth\Manager\ClientManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZF\OAuth2\Controller\Exception;

class ClientManagerFactory extends AbstractManagerFactory
{
    /**
     * @param ServiceLocatorInterface $services
     * @param array                   $config
     * @return ClientManager
     */
    protected function getManager(ServiceLocatorInterface $services, array $config)
    {
        $objectManager = $this->getObjectManager($services, $config);

        if (!isset($config['storage_settings']['client_entity_class']) || empty($config['storage_settings']['client_entity_class'])) {
            throw new Exception\RuntimeException('The client configuration [\'zf-oauth2\'][\'storage_settings\'][\'client_entity_class\'] for OAuth2 is missing');
        }

        $refl = new \ReflectionClass($config['storage_settings']['client_entity_class']);
        if (!$refl->implementsInterface('Security\\Entity\\OAuth\\ClientInterface')) {
            throw new Exception\RuntimeException('The class specified in [\'zf-oauth2\'][\'storage_settings\'][\'client_entity_class\'] must implement \Security\Entity\OAuth\ClientInterface');
        }

        $objectRepository = $this->getObjectRepository($objectManager, $config['storage_settings']['client_entity_class']);

        $managerConfig = array();
        if (isset($config['storage_settings']['client_identifier_property'])) {
            $managerConfig['identifier-property'] = $config['storage_settings']['client_identifier_property'];
        }

        return new ClientManager($objectManager, $objectRepository, $managerConfig);
    }
}

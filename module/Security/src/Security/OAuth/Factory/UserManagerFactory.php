<?php


namespace Security\OAuth\Factory;

use Security\OAuth\Manager\UserManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZF\OAuth2\Controller\Exception;

class UserManagerFactory extends AbstractManagerFactory
{
    /**
     * @param ServiceLocatorInterface $services
     * @param array                   $config
     * @return UserManager
     */
    protected function getManager(ServiceLocatorInterface $services, array $config)
    {
        $objectManager = $this->getObjectManager($services, $config);

        if (!isset($config['storage_settings']['user_entity_class']) || empty($config['storage_settings']['user_entity_class'])) {
            throw new Exception\RuntimeException('The user configuration [\'zf-oauth2\'][\'storage_settings\'][\'user_entity_class\'] for OAuth2 is missing');
        }

        $refl = new \ReflectionClass($config['storage_settings']['user_entity_class']);
        if (!$refl->implementsInterface('Security\\Entity\\OAuth\\UserInterface')) {
            throw new Exception\RuntimeException('The class specified in [\'zf-oauth2\'][\'storage_settings\'][\'user_entity_class\'] must implement \Security\Entity\OAuth\UserInterface');
        }

        $objectRepository = $this->getObjectRepository($objectManager, $config['storage_settings']['user_entity_class']);

        $managerConfig = array();
        if (isset($config['storage_settings']['user_username_property'])) {
            $managerConfig['username-property'] = $config['storage_settings']['user_username_property'];
        }

        return new UserManager($objectManager, $objectRepository, $managerConfig);
    }
}

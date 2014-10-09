<?php


namespace Security\OAuth\Factory;

use Security\OAuth\Adapter\DoctrineAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZF\OAuth2\Controller\Exception;

class DoctrineAdapterFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @throws \ZF\OAuth2\Controller\Exception\RuntimeException
     * @return \ZF\OAuth2\Adapter\PdoAdapter
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Config');

        $oauth2ServerConfig = array();
        if (isset($config['zf-oauth2']['storage_settings']) && is_array($config['zf-oauth2']['storage_settings'])) {
            $oauth2ServerConfig = $config['zf-oauth2']['storage_settings'];
        }

        $adapter = new DoctrineAdapter($oauth2ServerConfig);

        $adapter->setAccessTokenManager($services->get('Security\OAuth\Manager\AccessTokenManager'));
        $adapter->setAuthorizationManager($services->get('Security\OAuth\Manager\AuthorizationCodeManager'));
        $adapter->setRefreshTokenManager($services->get('Security\OAuth\Manager\RefreshTokenManager'));
        $adapter->setClientManager($services->get('Security\OAuth\Manager\ClientManager'));
        $adapter->setUserManager($services->get('Security\OAuth\Manager\UserManager'));

        return $adapter;
    }
}

<?php


namespace OAuth\Factory;


use OAuth\Adapter\DoctrineAdapter;
use OAuth\Manager\AccessTokenManager;
use OAuth\Manager\AuthorizationCodeManager;
use OAuth\Manager\ClientManager;
use OAuth\Manager\RefreshTokenManager;
use OAuth\Manager\UserManager;
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

        if (!isset($config['zf-oauth2']['object_manager']) || empty($config['zf-oauth2']['object_manager'])) {
            throw new Exception\RuntimeException(
                'The object_manager configuration [\'zf-oauth2\'][\'object_manager\'] for OAuth2 is missing'
            );
        }

        $objectManager = $services->get($config['zf-oauth2']['object_manager']);

        $oauth2ServerConfig = array();
        if (isset($config['zf-oauth2']['storage_settings']) && is_array($config['zf-oauth2']['storage_settings'])) {
            $oauth2ServerConfig = $config['zf-oauth2']['storage_settings'];
        }

        $adapter = new DoctrineAdapter($oauth2ServerConfig);

        $adapter->setAccessTokenManager(new AccessTokenManager($objectManager));
        $adapter->setAuthorizationManager(new AuthorizationCodeManager($objectManager));
        $adapter->setClientManager(new ClientManager($objectManager, $oauth2ServerConfig));
        $adapter->setUserManager(new UserManager($objectManager, $oauth2ServerConfig));
        $adapter->setRefreshTokenManager(new RefreshTokenManager($objectManager));

        return $adapter;
    }
}

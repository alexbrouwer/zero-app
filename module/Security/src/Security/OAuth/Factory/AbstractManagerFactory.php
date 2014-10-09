<?php


namespace Security\OAuth\Factory;

use Doctrine\Common\Persistence\ObjectManager;
use Security\OAuth\Manager\AbstractManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZF\OAuth2\Controller\Exception;

abstract class AbstractManagerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $services
     * @throws \ZF\OAuth2\Controller\Exception\RuntimeException
     * @return AbstractManager
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Config');

        $oAuthConfig = array();
        if(isset($config['zf-oauth2'])) {
            $oAuthConfig = $config['zf-oauth2'];
        }

        return $this->getManager($services, $oAuthConfig);
    }

    /**
     * @param ServiceLocatorInterface $services
     * @param array                   $config
     * @return ObjectManager
     */
    protected function getObjectManager(ServiceLocatorInterface $services, array $config)
    {
        if (!isset($config['object_manager']) || empty($config['object_manager'])) {
            throw new Exception\RuntimeException(
                'The object_manager configuration [\'zf-oauth2\'][\'object_manager\'] for OAuth2 is missing'
            );
        }

        return $services->get($config['object_manager']);
    }

    /**
     * @param ObjectManager $objectManager
     * @param string        $entityClass
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getObjectRepository(ObjectManager $objectManager, $entityClass)
    {
        return $objectManager->getRepository($entityClass);
    }

    /**
     * @param ServiceLocatorInterface $services
     * @param array                   $config
     * @return AbstractManager
     */
    abstract protected function getManager(ServiceLocatorInterface $services, array $config);
}

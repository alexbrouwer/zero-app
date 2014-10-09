<?php


namespace Security\Authorization;

use Rbac\Traversal\Strategy\GeneratorStrategy;
use Rbac\Traversal\Strategy\RecursiveRoleIteratorStrategy;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZF\MvcAuth\Factory\AclAuthorizationFactory;

class RbacAuthorizationFactory extends AclAuthorizationFactory
{
    /**
     * Create the DefaultAuthorizationListener
     *
     * @param ServiceLocatorInterface $services
     * @return \ZF\MvcAuth\Authorization\AuthorizationInterface
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config = array();
        if ($services->has('config')) {
            $config = $services->get('config');
        }

        $acl = $this->createAclFromConfig($config);
        $rbac = $this->getRbac();
        $rbac->setAcl($acl);

        return $rbac;
    }

    protected function getRbac()
    {
        if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            $traversalStrategy = new GeneratorStrategy();
        } else {
            $traversalStrategy = new RecursiveRoleIteratorStrategy();
        }
        return new RbacAuthorization($traversalStrategy);
    }
}

<?php


namespace Security\Authorization;

use Rbac\Rbac;
use Zend\Permissions\Acl\Acl;
use ZF\MvcAuth\Authorization\AuthorizationInterface;
use ZF\MvcAuth\Identity\IdentityInterface;

class RbacAuthorization extends Rbac implements AuthorizationInterface
{

    /**
     * @var Acl
     */
    protected $acl;

    /**
     * @param Acl $acl
     * @return $this
     */
    public function setAcl(Acl $acl)
    {
        $this->acl = $acl;

        return $this;
    }

    /**
     * Whether or not the given identity has the given privilege on the given resource.
     *
     * @param IdentityInterface $identity
     * @param mixed             $resource
     * @param mixed             $privilege
     * @return bool
     */
    public function isAuthorized(IdentityInterface $identity, $resource, $privilege)
    {
        if (null !== $resource && (! $this->acl->hasResource($resource))) {
            $this->acl->addResource($resource);
        }

        if (!$this->acl->hasRole($identity)) {
            $this->acl->addRole($identity);
        }

        return $this->acl->isAllowed($identity, $resource, $privilege);
    }
}

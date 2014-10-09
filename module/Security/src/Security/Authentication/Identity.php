<?php


namespace Security\Authentication;

use Db\Entity\User\Permission;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Rbac\Role\HierarchicalRoleInterface;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;

class Identity extends AuthenticatedIdentity
{
    public function __construct($identity)
    {
        parent::__construct($identity);

        $this->children = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function addChild($child)
    {
        if (!$child instanceof HierarchicalRoleInterface) {
            return;
        }
        $this->children[] = $child;
    }

    /*
     * Set the list of permission
     * @param Collection $permissions
     */
    public function setPermissions($permissions)
    {
        $this->permissions->clear();
        foreach ($permissions as $permission) {
            $this->permissions[] = $permission;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function addPermission($permission)
    {
        if (is_string($permission)) {
            $permission = new Permission($permission);
        }

        $this->permissions[(string)$permission] = $permission;
    }

    /**
     * {@inheritDoc}
     */
    public function hasPermission($permission)
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq('name', (string)$permission));
        $result = $this->permissions->matching($criteria);

        return count($result) > 0;
    }

    /**
     * {@inheritDoc}
     */
    public function getChildren()
    {
        return $this->children->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function hasChildren()
    {
        return !$this->children->isEmpty();
    }
}

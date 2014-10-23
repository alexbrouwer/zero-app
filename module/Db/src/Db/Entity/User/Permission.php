<?php


namespace Db\Entity\User;

class Permission
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * Constructor
     */
    public function __construct($name)
    {
        $this->name = (string)$name;
    }

    /**
     * Get the permission identifier
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Permission
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->name;
    }
}

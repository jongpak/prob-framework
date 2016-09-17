<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="permisions")
 */
class Permission
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string", length=128)
     */
    protected $operation;

    /**
     * @ManyToMany(targetEntity="Role")
     * @JoinTable(name="role_permissions")
     */
    protected $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getRoles()
    {
        return $this->roles;
    }
}

<?php

namespace Adteam\Core\Powerbi\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CorePermissions
 *
 * @ORM\Table(name="core_permissions", uniqueConstraints={@ORM\UniqueConstraint(name="permission_key", columns={"role_id", "resource_id"})}, indexes={@ORM\Index(name="core_permissions_ibfk_2", columns={"resource_id"}), @ORM\Index(name="IDX_FADC5205D60322AC", columns={"role_id"})})
 * @ORM\Entity
 */
class CorePermissions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="permission", type="string", precision=0, scale=0, nullable=false, unique=false)
     */
    private $permission;

    /**
     * @var \Adteam\Core\Powerbi\Entity\CoreRoles
     *
     * @ORM\ManyToOne(targetEntity="Adteam\Core\Powerbi\Entity\CoreRoles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $role;

    /**
     * @var \Adteam\Core\Powerbi\Entity\CoreResources
     *
     * @ORM\ManyToOne(targetEntity="Adteam\Core\Powerbi\Entity\CoreResources")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="resource_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $resource;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set permission
     *
     * @param string $permission
     *
     * @return CorePermissions
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get permission
     *
     * @return string
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set role
     *
     * @param \Adteam\Core\Powerbi\Entity\CoreRoles $role
     *
     * @return CorePermissions
     */
    public function setRole(\Adteam\Core\Powerbi\Entity\CoreRoles $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Adteam\Core\Powerbi\Entity\CoreRoles
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set resource
     *
     * @param \Adteam\Core\Powerbi\Entity\CoreResources $resource
     *
     * @return CorePermissions
     */
    public function setResource(\Adteam\Core\Powerbi\Entity\CoreResources $resource = null)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return \Adteam\Core\Powerbi\Entity\CoreResources
     */
    public function getResource()
    {
        return $this->resource;
    }
}


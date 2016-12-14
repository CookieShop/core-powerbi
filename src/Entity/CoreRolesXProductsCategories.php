<?php

namespace Adteam\Core\Powerbi\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoreRolesXProductsCategories
 *
 * @ORM\Table(name="core_roles_x_products_categories", uniqueConstraints={@ORM\UniqueConstraint(name="AK_roles_categories", columns={"role_id", "category_id"})}, indexes={@ORM\Index(name="category_id", columns={"category_id"}), @ORM\Index(name="role_id", columns={"role_id"})})
 * @ORM\Entity
 */
class CoreRolesXProductsCategories
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
     * @var \Adteam\Core\Powerbi\Entity\CoreProductCategories
     *
     * @ORM\ManyToOne(targetEntity="Adteam\Core\Powerbi\Entity\CoreProductCategories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $category;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set category
     *
     * @param \Adteam\Core\Powerbi\Entity\CoreProductCategories $category
     *
     * @return CoreRolesXProductsCategories
     */
    public function setCategory(\Adteam\Core\Powerbi\Entity\CoreProductCategories $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Adteam\Core\Powerbi\Entity\CoreProductCategories
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set role
     *
     * @param \Adteam\Core\Powerbi\Entity\CoreRoles $role
     *
     * @return CoreRolesXProductsCategories
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
}


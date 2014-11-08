<?php

namespace Groups\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryGroup
 *
 * @ORM\Table(name="category_groups")
 * @ORM\Entity
 */
class CategoryGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="group_id", type="integer")
     */
    private $groupId;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer")
     */
    private $categoryId;

    /**
     * @ORM\ManyToOne(targetEntity="DefaultTables\ModelBundle\Entity\Categories", inversedBy="group_categories",
     * cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

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
     * Set groupId
     *
     * @param integer $groupId
     * @return CategoryGroup
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * Get groupId
     *
     * @return integer 
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     * @return CategoryGroup
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set category
     *
     * @param \DefaultTables\ModelBundle\Entity\Categories $category
     * @return CategoryGroup
     */
    public function setCategory(\DefaultTables\ModelBundle\Entity\Categories $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \DefaultTables\ModelBundle\Entity\Categories 
     */
    public function getCategory()
    {
        return $this->category;
    }
}

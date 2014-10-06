<?php

namespace DefaultTables\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Categories
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**

     * @ORM\OneToMany(targetEntity="Groups\ModelBundle\Entity\CategoryGroup", mappedBy="category")
     */
    protected $group_categories;

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
     * Set name
     *
     * @param string $name
     * @return Categories
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->group_categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add group_categories
     *
     * @param \Groups\ModelBundle\Entity\CategoryGroup $groupCategories
     * @return Categories
     */
    public function addGroupCategory(\Groups\ModelBundle\Entity\CategoryGroup $groupCategories)
    {
        $this->group_categories[] = $groupCategories;

        return $this;
    }

    /**
     * Remove group_categories
     *
     * @param \Groups\ModelBundle\Entity\CategoryGroup $groupCategories
     */
    public function removeGroupCategory(\Groups\ModelBundle\Entity\CategoryGroup $groupCategories)
    {
        $this->group_categories->removeElement($groupCategories);
    }

    /**
     * Get group_categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupCategories()
    {
        return $this->group_categories;
    }
}

<?php

namespace Groups\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * GroupUsers
 *
 * @ORM\Table(name="group_users")
 * @ORM\Entity(repositoryClass="Groups\ModelBundle\Repo\GroupUsersRepo")
 */
class GroupUsers
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
     * @var \integer
     *
     * @ORM\Column(name="active",type="integer")
     */

    private $active;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \DateTime $contentChanged
     *
     * @ORM\Column(name="content_changed", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"active"})
     */
    private $contentChanged;

    /**
     * @ORM\ManyToOne(targetEntity="Users\ModelBundle\Entity\User", inversedBy="group_users",cascade={"persist",
     * "remove"}))
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Groups\ModelBundle\Entity\Groups", inversedBy="group_users",cascade={"persist",
     * "remove"}))
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return GroupUsers
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return GroupUsers
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return GroupUsers
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set user
     *
     * @param \Users\ModelBundle\Entity\User $user
     * @return GroupUsers
     */
    public function setUser(\Users\ModelBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Users\ModelBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set group
     *
     * @param \Groups\ModelBundle\Entity\Groups $group
     * @return GroupUsers
     */
    public function setGroup(\Groups\ModelBundle\Entity\Groups $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Groups\ModelBundle\Entity\Groups 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set contentChanged
     *
     * @param \DateTime $contentChanged
     * @return GroupUsers
     */
    public function setContentChanged($contentChanged)
    {
        $this->contentChanged = $contentChanged;

        return $this;
    }

    /**
     * Get contentChanged
     *
     * @return \DateTime 
     */
    public function getContentChanged()
    {
        return $this->contentChanged;
    }
}

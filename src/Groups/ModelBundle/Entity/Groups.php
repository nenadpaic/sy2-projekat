<?php

namespace Groups\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Groups
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity
 */
class Groups
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\Regex(pattern="/^[a-zA-Z0-9_-' ]+$/i",htmlPattern = "^[a-zA-Z0-9_-' ]+$",match=true,
     * message="groups.no_special_chars")
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=60, minMessage="Group name can not be less than {{ limit }} characters long", maxMessage="Group name can not be longer than {{ limit }} characters long")

     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=2000, minMessage="Group description can not be less than {{ limit }} characters long", maxMessage="Group description can not be longer than {{ limit }} characters long")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="group_logo", type="string", length=255, nullable=true)
     */
    private $groupLogo;

    /**
     * @var string
     *
     * @ORM\Column(name="group_cover", type="string", length=255, nullable=true)
     */
    private $groupCover;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false, separator="-")
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
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
     * @Gedmo\Timestampable(on="change", field={"name","description","group_logo","group_cover"})
     */
    private $contentChanged;

    /**
     * @ORM\ManyToOne(targetEntity="Users\ModelBundle\Entity\User", inversedBy="groups"))
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="Groups\ModelBundle\Entity\GroupTopic", mappedBy="group",cascade={"persist", "remove"})
     */
    protected $group_topic;


    /**
     * @ORM\OneToMany(targetEntity="Groups\ModelBundle\Entity\GroupUsers", mappedBy="group",cascade={"persist", "remove"})
     */
    protected $group_users;

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
     * @return Groups
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
     * Set description
     *
     * @param string $description
     * @return Groups
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set groupLogo
     *
     * @param string $groupLogo
     * @return Groups
     */
    public function setGroupLogo($groupLogo)
    {
        $this->groupLogo = $groupLogo;

        return $this;
    }

    /**
     * Get groupLogo
     *
     * @return string 
     */
    public function getGroupLogo()
    {
        return $this->groupLogo;
    }

    /**
     * Set groupCover
     *
     * @param string $groupCover
     * @return Groups
     */
    public function setGroupCover($groupCover)
    {
        $this->groupCover = $groupCover;

        return $this;
    }

    /**
     * Get groupCover
     *
     * @return string 
     */
    public function getGroupCover()
    {
        return $this->groupCover;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Groups
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
     * @return Groups
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
     * Set user
     *
     * @param \Users\ModelBundle\Entity\User $user
     * @return Groups
     */
    public function setUser(\Users\ModelBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Set contentChanged
     *
     * @param \DateTime $contentChanged
     * @return Groups
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

    /**
     * Set slug
     *
     * @param string $slug
     * @return Groups
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->group_topic = new \Doctrine\Common\Collections\ArrayCollection();
        $this->group_topic_comment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->group_topic_comment_reply = new \Doctrine\Common\Collections\ArrayCollection();
        $this->group_users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add group_topic
     *
     * @param \Groups\ModelBundle\Entity\GroupTopic $groupTopic
     * @return Groups
     */
    public function addGroupTopic(\Groups\ModelBundle\Entity\GroupTopic $groupTopic)
    {
        $this->group_topic[] = $groupTopic;

        return $this;
    }

    /**
     * Remove group_topic
     *
     * @param \Groups\ModelBundle\Entity\GroupTopic $groupTopic
     */
    public function removeGroupTopic(\Groups\ModelBundle\Entity\GroupTopic $groupTopic)
    {
        $this->group_topic->removeElement($groupTopic);
    }

    /**
     * Get group_topic
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupTopic()
    {
        return $this->group_topic;
    }


    /**
     * Add group_users
     *
     * @param \Groups\ModelBundle\Entity\GroupUsers $groupUsers
     * @return Groups
     */
    public function addGroupUser(\Groups\ModelBundle\Entity\GroupUsers $groupUsers)
    {
        $this->group_users[] = $groupUsers;

        return $this;
    }

    /**
     * Remove group_users
     *
     * @param \Groups\ModelBundle\Entity\GroupUsers $groupUsers
     */
    public function removeGroupUser(\Groups\ModelBundle\Entity\GroupUsers $groupUsers)
    {
        $this->group_users->removeElement($groupUsers);
    }

    /**
     * Get group_users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupUsers()
    {
        return $this->group_users;
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
}

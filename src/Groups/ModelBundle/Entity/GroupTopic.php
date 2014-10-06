<?php

namespace Groups\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * GroupTopic
 *
 * @ORM\Table(name="group_topics")
 * @ORM\Entity
 */
class GroupTopic
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

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
     * @Gedmo\Timestampable(on="change", field={"title","message"})
     */
    private $contentChanged;


    /**
     * @ORM\ManyToOne(targetEntity="Users\ModelBundle\Entity\User", inversedBy="group_topic",cascade={"persist",
     * "remove"}))
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Groups\ModelBundle\Entity\Groups", inversedBy="group_topic",cascade={"persist",
     * "remove"}))
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;

    /**
     * @ORM\OneToMany(targetEntity="Groups\ModelBundle\Entity\GroupTopicComment", mappedBy="group_topic")
     */
    protected $group_topic_comment;


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
     * @return GroupTopic
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
     * Set title
     *
     * @param string $title
     * @return GroupTopic
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return GroupTopic
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return GroupTopic
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return GroupTopic
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
     * @return GroupTopic
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
     * Constructor
     */
    public function __construct()
    {
        $this->group_topic_comment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->group_topic_comment_reply = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set user
     *
     * @param \Users\ModelBundle\Entity\User $user
     * @return GroupTopic
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
     * @return GroupTopic
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
     * Add group_topic_comment
     *
     * @param \Groups\ModelBundle\Entity\GroupTopicComment $groupTopicComment
     * @return GroupTopic
     */
    public function addGroupTopicComment(\Groups\ModelBundle\Entity\GroupTopicComment $groupTopicComment)
    {
        $this->group_topic_comment[] = $groupTopicComment;

        return $this;
    }

    /**
     * Remove group_topic_comment
     *
     * @param \Groups\ModelBundle\Entity\GroupTopicComment $groupTopicComment
     */
    public function removeGroupTopicComment(\Groups\ModelBundle\Entity\GroupTopicComment $groupTopicComment)
    {
        $this->group_topic_comment->removeElement($groupTopicComment);
    }

    /**
     * Get group_topic_comment
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupTopicComment()
    {
        return $this->group_topic_comment;
    }

    /**
     * Add group_topic_comment_reply
     *
     * @param \Groups\ModelBundle\Entity\GroupTopicCommentReply $groupTopicCommentReply
     * @return GroupTopic
     */
    public function addGroupTopicCommentReply(\Groups\ModelBundle\Entity\GroupTopicCommentReply $groupTopicCommentReply)
    {
        $this->group_topic_comment_reply[] = $groupTopicCommentReply;

        return $this;
    }

    /**
     * Remove group_topic_comment_reply
     *
     * @param \Groups\ModelBundle\Entity\GroupTopicCommentReply $groupTopicCommentReply
     */
    public function removeGroupTopicCommentReply(\Groups\ModelBundle\Entity\GroupTopicCommentReply $groupTopicCommentReply)
    {
        $this->group_topic_comment_reply->removeElement($groupTopicCommentReply);
    }

    /**
     * Get group_topic_comment_reply
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupTopicCommentReply()
    {
        return $this->group_topic_comment_reply;
    }

    /**
     * Set contentChanged
     *
     * @param \DateTime $contentChanged
     * @return GroupTopic
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

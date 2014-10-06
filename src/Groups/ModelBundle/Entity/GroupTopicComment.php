<?php

namespace Groups\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GroupTopicComment
 *
 * @ORM\Table(name="group_topic_comments")
 * @ORM\Entity
 */
class GroupTopicComment
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
     * @ORM\Column(name="topic_id", type="integer")
     */
    private $topicId;

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
     * @Gedmo\Timestampable(on="change", field={"message"})
     */
    private $contentChanged;

    /**
     * @ORM\ManyToOne(targetEntity="Users\ModelBundle\Entity\User", inversedBy="group_topic_comment",cascade={"persist",
     * "remove"}))
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Groups\ModelBundle\Entity\GroupTopic", inversedBy="group_topic_comment",cascade={"persist",
     * "remove"}))
     * @ORM\JoinColumn(name="topic_id", referencedColumnName="id")
     */
    protected $group_topic;

    /**
     * @ORM\OneToMany(targetEntity="Groups\ModelBundle\Entity\GroupTopicCommentReply", mappedBy="group_topic_comment")
     */
    protected $group_topic_comment_reply;



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
     * @return GroupTopicComment
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
     * Set topicId
     *
     * @param integer $topicId
     * @return GroupTopicComment
     */
    public function setTopicId($topicId)
    {
        $this->topicId = $topicId;

        return $this;
    }

    /**
     * Get topicId
     *
     * @return integer 
     */
    public function getTopicId()
    {
        return $this->topicId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return GroupTopicComment
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
     * @return GroupTopicComment
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
     * @return GroupTopicComment
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
     * @return GroupTopicComment
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
        $this->group_topic_comment_reply = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set user
     *
     * @param \Users\ModelBundle\Entity\User $user
     * @return GroupTopicComment
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
     * @return GroupTopicComment
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
     * Set group_topic
     *
     * @param \Groups\ModelBundle\Entity\GroupTopic $groupTopic
     * @return GroupTopicComment
     */
    public function setGroupTopic(\Groups\ModelBundle\Entity\GroupTopic $groupTopic = null)
    {
        $this->group_topic = $groupTopic;

        return $this;
    }

    /**
     * Get group_topic
     *
     * @return \Groups\ModelBundle\Entity\GroupTopic 
     */
    public function getGroupTopic()
    {
        return $this->group_topic;
    }

    /**
     * Add group_topic_comment_reply
     *
     * @param \Groups\ModelBundle\Entity\GroupTopicCommentReply $groupTopicCommentReply
     * @return GroupTopicComment
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
     * @return GroupTopicComment
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

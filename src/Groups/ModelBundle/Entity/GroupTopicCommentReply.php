<?php

namespace Groups\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GroupTopicCommentReply
 *
 * @ORM\Table(name="group_topic_comments_replies")
 * @ORM\Entity(repositoryClass="Groups\ModelBundle\Repo\GroupTopicCommentRepliesRepo")
 */
class GroupTopicCommentReply
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
     * @ORM\Column(name="message", type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=2000, minMessage="Reply can not be less than {{ limit }} characters long", maxMessage="Reply can not be longer than {{ limit }} characters long")

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
     * @ORM\ManyToOne(targetEntity="Users\ModelBundle\Entity\User", inversedBy="group_topic_comment_reply"))
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;


    /**
     * @ORM\ManyToOne(targetEntity="Groups\ModelBundle\Entity\GroupTopicComment", inversedBy="group_topic_comment_reply"))
     * @ORM\JoinColumn(name="comment_id", referencedColumnName="id")
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
     * Set message
     *
     * @param string $message
     * @return GroupTopicCommentReply
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
     * @return GroupTopicCommentReply
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
     * @return GroupTopicCommentReply
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
     * @return GroupTopicCommentReply
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
     * Set group_topic_comment
     *
     * @param \Groups\ModelBundle\Entity\GroupTopicComment $groupTopicComment
     * @return GroupTopicCommentReply
     */
    public function setGroupTopicComment(\Groups\ModelBundle\Entity\GroupTopicComment $groupTopicComment = null)
    {
        $this->group_topic_comment = $groupTopicComment;

        return $this;
    }

    /**
     * Get group_topic_comment
     *
     * @return \Groups\ModelBundle\Entity\GroupTopicComment 
     */
    public function getGroupTopicComment()
    {
        return $this->group_topic_comment;
    }

    /**
     * Set contentChanged
     *
     * @param \DateTime $contentChanged
     * @return GroupTopicCommentReply
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

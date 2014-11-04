<?php

namespace Report\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Reports
 *
 * @ORM\Table(name="user_reports")
 * @ORM\Entity(repositoryClass="Report\ModelBundle\Repo\ReportsRepo")
 */
class Reports
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
     * @ORM\Column(name="component_id", type="integer")
     */
    private $componentId;

    /**
     * @var string
     *
     * @ORM\Column(name="component_name", type="string", length=255)
     */
    private $componentName;

    /**
     * @var string
     *
     * @ORM\Column(name="component_text", type="text")
     */
    private $componentText;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    /**
     * @var \DateTime $contentChanged
     *
     * @ORM\Column(name="content_changed", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={""})
     */
    private $contentChanged;

    /**
     * @ORM\ManyToOne(targetEntity="DefaultTables\ModelBundle\Entity\Components", inversedBy="report"))
     * @ORM\JoinColumn(name="component", referencedColumnName="id")
     */
    protected $component;

    /**
     * @ORM\ManyToOne(targetEntity="Users\ModelBundle\Entity\User", inversedBy="reported_user"))
     * @ORM\JoinColumn(name="reported_user_id", referencedColumnName="id")
     */
    protected $reported_user;

    /**
     * @ORM\ManyToOne(targetEntity="Users\ModelBundle\Entity\User", inversedBy="user_reporting"))
     * @ORM\JoinColumn(name="user_reporting_id", referencedColumnName="id")
     */
    protected $user_reporting;

    /**
     * @ORM\ManyToOne(targetEntity="Report\ModelBundle\Entity\Actions", inversedBy="report"))
     * @ORM\JoinColumn(name="action_id", referencedColumnName="id")
     */
    protected $action;

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
     * Set componentId
     *
     * @param integer $componentId
     * @return Reports
     */
    public function setComponentId($componentId)
    {
        $this->componentId = $componentId;

        return $this;
    }

    /**
     * Get componentId
     *
     * @return integer 
     */
    public function getComponentId()
    {
        return $this->componentId;
    }

    /**
     * Set componentName
     *
     * @param string $componentName
     * @return Reports
     */
    public function setComponentName($componentName)
    {
        $this->componentName = $componentName;

        return $this;
    }

    /**
     * Get componentName
     *
     * @return string 
     */
    public function getComponentName()
    {
        return $this->componentName;
    }

    /**
     * Set componentText
     *
     * @param string $componentText
     * @return Reports
     */
    public function setComponentText($componentText)
    {
        $this->componentText = $componentText;

        return $this;
    }

    /**
     * Get componentText
     *
     * @return string 
     */
    public function getComponentText()
    {
        return $this->componentText;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Reports
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
     * @return Reports
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
     * Set contentChanged
     *
     * @param \DateTime $contentChanged
     * @return Reports
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
     * Set component
     *
     * @param \DefaultTables\ModelBundle\Entity\Components $component
     * @return Reports
     */
    public function setComponent(\DefaultTables\ModelBundle\Entity\Components $component = null)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return \DefaultTables\ModelBundle\Entity\Components 
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Set reported_user
     *
     * @param \Users\ModelBundle\Entity\User $reportedUser
     * @return Reports
     */
    public function setReportedUser(\Users\ModelBundle\Entity\User $reportedUser = null)
    {
        $this->reported_user = $reportedUser;

        return $this;
    }

    /**
     * Get reported_user
     *
     * @return \Users\ModelBundle\Entity\User 
     */
    public function getReportedUser()
    {
        return $this->reported_user;
    }

    /**
     * Set user_reporting
     *
     * @param \Users\ModelBundle\Entity\User $userReporting
     * @return Reports
     */
    public function setUserReporting(\Users\ModelBundle\Entity\User $userReporting = null)
    {
        $this->user_reporting = $userReporting;

        return $this;
    }

    /**
     * Get user_reporting
     *
     * @return \Users\ModelBundle\Entity\User 
     */
    public function getUserReporting()
    {
        return $this->user_reporting;
    }

    /**
     * Set action
     *
     * @param \Report\ModelBundle\Entity\Actions $action
     * @return Reports
     */
    public function setAction(\Report\ModelBundle\Entity\Actions $action = null)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return \Report\ModelBundle\Entity\Actions 
     */
    public function getAction()
    {
        return $this->action;
    }
}

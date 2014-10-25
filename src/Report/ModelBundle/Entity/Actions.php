<?php

namespace Report\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actions
 *
 * @ORM\Table(name="user_reports_actions")
 * @ORM\Entity
 */
class Actions
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
     * @ORM\OneToMany(targetEntity="Report\ModelBundle\Entity\Reports", mappedBy="action",cascade={"persist",
     * "remove"})
     */
    protected $report;


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
     * @return Actions
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
        $this->report = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add report
     *
     * @param \Groups\ModelBundle\Entity\Reports $report
     * @return Actions
     */
    public function addReport(\Groups\ModelBundle\Entity\Reports $report)
    {
        $this->report[] = $report;

        return $this;
    }

    /**
     * Remove report
     *
     * @param \Groups\ModelBundle\Entity\Reports $report
     */
    public function removeReport(\Groups\ModelBundle\Entity\Reports $report)
    {
        $this->report->removeElement($report);
    }

    /**
     * Get report
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReport()
    {
        return $this->report;
    }
}

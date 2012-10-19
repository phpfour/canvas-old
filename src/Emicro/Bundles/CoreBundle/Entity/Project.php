<?php

namespace Emicro\Bundles\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Emicro\Bundles\CoreBundle\Entity\ProjectRepository")
 * @ORM\Table(name="projects")
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(type="string", length=100) */
    protected $title;

    /** @ORM\OneToMany(targetEntity="Canvas", mappedBy="project") */
    protected $canvases;

    /** @ORM\Column(type="datetime") */
    protected $createDate;

    /** @ORM\Column(type="datetime") */
    protected $updateDate;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->canvases = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set title
     *
     * @param string $title
     * @return Project
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
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Project
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return Project
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;
        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime 
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Add canvases
     *
     * @param \Emicro\Bundles\CoreBundle\Entity\Canvas $canvases
     * @return Project
     */
    public function addCanvas(\Emicro\Bundles\CoreBundle\Entity\Canvas $canvases)
    {
        $this->canvases[] = $canvases;
        return $this;
    }

    /**
     * Remove canvases
     *
     * @param \Emicro\Bundles\CoreBundle\Entity\Canvas $canvases
     */
    public function removeCanvas(\Emicro\Bundles\CoreBundle\Entity\Canvas $canvases)
    {
        $this->canvases->removeElement($canvases);
    }

    /**
     * Get canvases
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCanvases()
    {
        return $this->canvases;
    }
}
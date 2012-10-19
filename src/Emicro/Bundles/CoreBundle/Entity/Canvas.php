<?php

namespace Emicro\Bundles\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Emicro\Bundles\CoreBundle\Entity\CanvasRepository")
 * @ORM\Table(name="canvases")
 */
class Canvas
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(type="string", length=100, nullable=true) */
    protected $title;

    /** @ORM\Column(type="string", length=250, nullable=true) */
    protected $image;

    /** @ORM\Column(type="array", nullable=true) */
    protected $markers;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="canvases")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /** @ORM\Column(type="datetime") */
    protected $createDate;

    /** @ORM\Column(type="datetime") */
    protected $updateDate;

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
     * @return Canvas
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
     * @return Canvas
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
     * @return Canvas
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
     * Set project
     *
     * @param \Emicro\Bundles\CoreBundle\Entity\Project $project
     * @return Canvas
     */
    public function setProject(\Emicro\Bundles\CoreBundle\Entity\Project $project = null)
    {
        $this->project = $project;
        return $this;
    }

    /**
     * Get project
     *
     * @return \Emicro\Bundles\CoreBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Canvas
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set markers
     *
     * @param array $markers
     * @return Canvas
     */
    public function setMarkers($markers)
    {
        $this->markers = $markers;
        return $this;
    }

    /**
     * Get markers
     *
     * @return array 
     */
    public function getMarkers()
    {
        return $this->markers;
    }
}
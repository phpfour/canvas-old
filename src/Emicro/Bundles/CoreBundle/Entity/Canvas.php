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

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="canvases")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="canvases")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    protected $user;

    /** @ORM\Column(type="string", length=100, nullable=true) */
    protected $title;

    /** @ORM\Column(type="text", nullable=true) */
    protected $details;

    /** @ORM\Column(type="string", length=250, nullable=true) */
    protected $image;

    /** @ORM\Column(type="array", nullable=true) */
    protected $markers;

    /** @ORM\Column(type="datetime", nullable=true) */
    protected $createDate;

    /** @ORM\Column(type="datetime", nullable=true) */
    protected $updateDate;

    public function toArray()
    {
        $data = array(
            'id'      => $this->getId(),
            'title'   => $this->getTitle(),
            'image'   => $this->getImage(),
            'details' => $this->getDetails()
        );

        if (!is_null($this->getProject())) {
            $data['project'] = $this->getProject()->toArray();
        } else {
            $data['project'] = null;
        }

        if (!is_null($this->getMarkers())) {
            $data['markers'] = $this->getMarkers();
        } else {
            $data['markers'] = array();
        }

        return $data;
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

    /**
     * Set details
     *
     * @param string $details
     * @return Canvas
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }

    /**
     * Get details
     *
     * @return string 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set user
     *
     * @param \Emicro\Bundles\CoreBundle\Entity\User $user
     * @return Canvas
     */
    public function setUser(\Emicro\Bundles\CoreBundle\Entity\User $user = null)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return \Emicro\Bundles\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
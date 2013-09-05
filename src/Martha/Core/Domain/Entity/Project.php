<?php

namespace Martha\Core\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Project
 * @package Martha\Core\Domain
 */
class Project extends AbstractEntity
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $scm;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $builds;

    /**
     * Set us up the class!
     */
    public function __construct()
    {
        $this->builds = new ArrayCollection();
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $scm
     * @return $this
     */
    public function setScm($scm)
    {
        $this->scm = $scm;
        return $this;
    }

    /**
     * @return string
     */
    public function getScm()
    {
        return $this->scm;
    }

    /**
     * @param string $uri
     * @return $this
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $builds
     * @return $this
     */
    public function setBuilds(ArrayCollection $builds)
    {
        $this->builds = $builds;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getBuilds()
    {
        return $this->builds;
    }
}

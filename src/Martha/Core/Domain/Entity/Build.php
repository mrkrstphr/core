<?php

namespace Martha\Core\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Build
 * @package Martha\Core\Domain\Entity
 */
class Build extends AbstractEntity
{
    /**
     * @var Project
     */
    protected $project;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $artifacts;

    /**
     * Set us up the class!
     */
    public function __construct()
    {
        $this->artifacts = new ArrayCollection();
    }

    /**
     * @param \Martha\Core\Domain\Entity\Project $project
     * @return $this
     */
    public function setProject($project)
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return \Martha\Core\Domain\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $artifacts
     * @return $this
     */
    public function setArtifacts($artifacts)
    {
        $this->artifacts = $artifacts;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getArtifacts()
    {
        return $this->artifacts;
    }
}

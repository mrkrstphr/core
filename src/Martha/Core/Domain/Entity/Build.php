<?php

namespace Martha\Core\Domain\Entity;

use DateTime;
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
     * @var \DateTime
     */
    protected $date;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $artifacts;

    /**
     * @var boolean
     */
    protected $wasSuccessful;

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
     * @param \DateTime $date
     * @return $this
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $artifacts
     * @return $this
     */
    public function setArtifacts(ArrayCollection $artifacts)
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

    /**
     * @param boolean $wasSuccessful
     * @return $this
     */
    public function setWasSuccessful($wasSuccessful)
    {
        $this->wasSuccessful = $wasSuccessful;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getWasSuccessful()
    {
        return $this->wasSuccessful;
    }
}

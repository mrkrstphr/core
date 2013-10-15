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
     * Status for when a build is scheduled, but not yet running.
     */
    const STATUS_PENDING = 'pending';

    /**
     * Status for when a build is currently running.
     */
    const STATUS_BUILDING = 'building';

    /**
     * Status for when a build has failed.
     */
    const STATUS_FAILURE = 'failure';

    /**
     * Status for when a build has succeeded.
     */
    const STATUS_SUCCESS = 'success';

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $artifacts;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $steps;

    /**
     * @var string
     */
    protected $branch;

    /**
     * @var string
     */
    protected $fork;

    /**
     * @var string
     */
    protected $forkUri;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $revisionNumber;

    /**
     * @var string
     */
    protected $status;

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
        $this->steps = new ArrayCollection();
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
     * @param string $branch
     * @return $this
     */
    public function setBranch($branch)
    {
        $this->branch = $branch;
        return $this;
    }

    /**
     * @return string
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * @param string $fork
     * @return $this
     */
    public function setFork($fork)
    {
        $this->fork = $fork;
        return $this;
    }

    /**
     * @return string
     */
    public function getFork()
    {
        return $this->fork;
    }

    /**
     * @param string $forkUri
     * @return $this
     */
    public function setForkUri($forkUri)
    {
        $this->forkUri = $forkUri;
        return $this;
    }

    /**
     * @return string
     */
    public function getForkUri()
    {
        return $this->forkUri;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $revisionNumber
     * @return $this
     */
    public function setRevisionNumber($revisionNumber)
    {
        $this->revisionNumber = $revisionNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getRevisionNumber()
    {
        return $this->revisionNumber;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return boolean
     */
    public function getWasSuccessful()
    {
        return $this->getStatus() == self::STATUS_SUCCESS;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setCreated(DateTime $date)
    {
        $this->created = $date;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
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
     * @param \Doctrine\Common\Collections\ArrayCollection $steps
     * @return $this
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSteps()
    {
        return $this->steps;
    }
}

<?php

namespace Martha\Core\Domain\Entity;

/**
 * Class Artifact
 * @package Martha\Core\Domain\Entity
 */
class Artifact extends AbstractEntity
{
    /**
     * @var Build
     */
    protected $build;

    /**
     * @var string
     */
    protected $application;

    /**
     * @var string
     */
    protected $file;

    /**
     * @param \Martha\Core\Domain\Entity\Build $build
     * @return $this
     */
    public function setBuild($build)
    {
        $this->build = $build;
        return $this;
    }

    /**
     * @return \Martha\Core\Domain\Entity\Build
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * @param string $application
     * @return $this
     */
    public function setApplication($application)
    {
        $this->application = $application;
        return $this;
    }

    /**
     * @return string
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param string $file
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
}

<?php

namespace Martha\Core\Build;

use Martha\Core\Job\AbstractJob;
use Martha\Core\Job\Trigger\TriggerAbstract;

/**
 * Class Build
 * @package Martha\Core\Build
 */
class Build
{
    /**
     * The Trigger that started the Build.
     * @var \Martha\Core\Job\Trigger\TriggerAbstract
     */
    protected $trigger;

    /**
     * The Job that this Build is building.
     * @var \Martha\Core\Job\AbstractJob
     */
    protected $job;

    /**
     * @var string
     */
    protected $workspace;

    /**
     * @var string
     */
    protected $buildPath;

    /**
     * @var int
     */
    protected $buildNumber;

    /**
     * @var string
     */
    protected $workingDirectory;

    /**
     * @param AbstractJob $job
     * @param TriggerAbstract $trigger
     * @param string $workspace
     * @param string $buildPath
     * @param int $buildNumber
     */
    public function __construct(AbstractJob $job, TriggerAbstract $trigger, $workspace, $buildPath, $buildNumber)
    {
        $this->job = $job;
        $this->trigger = $trigger;

        $this->workspace = $workspace;
        $this->buildPath = $buildPath;
        $this->buildNumber = $buildNumber;

        $this->workingDirectory = $workspace;
    }

    /**
     * Returns the Trigger that actually caused the Build to be started.
     *
     * @return \Martha\Core\Job\Trigger\TriggerAbstract
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * @param string $path
     * @throws \Exception
     */
    public function changeWorkingDirectory($path)
    {
        $candidate = realpath($this->getWorkspace() . '/' . $path);

        if ($candidate) {
            $this->workingDirectory = $candidate;
        } else {
            throw new \Exception('Invalid directory: ' . $candidate);
        }
    }

    /**
     * @return string
     */
    public function getBuildDirectory()
    {
        return $this->buildPath;
    }

    /**
     * @return int
     */
    public function getBuildNumber()
    {
        return $this->buildNumber;
    }

    /**
     * @return string
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }

    /**
     * Facilitates the running of a Build, including the preparation, actual building, and finally, the cleaning up.
     * All of this behavior is defined by the Job itself.
     *
     * @return boolean
     */
    public function run()
    {
        $this->job->prepare($this);
        $success = $this->job->run($this);
        $this->job->cleanup($this);

        return $success;
    }
}

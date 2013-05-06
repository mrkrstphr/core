<?php

namespace Martha\Core\Job;

use Martha\Core\Job\Trigger\TriggerAbstract;

/**
 * Class AbstractJob
 * @package Martha\Core\Job
 */
abstract class AbstractJob
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
     * @var boolean
     */
    protected $enabled = false;

    /**
     * @var \Martha\Core\Job\Trigger\TriggerAbstract
     */
    protected $trigger;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled === true;
    }

    /**
     * @param TriggerAbstract $trigger
     * @return $this
     */
    public function setTrigger(TriggerAbstract $trigger)
    {
        $this->trigger = $trigger;
        return $this;
    }

    /**
     * @return \Martha\Core\Job\Trigger\TriggerAbstract
     */
    public function getTrigger()
    {

    }

    public function changeWorkingDirectory($path)
    {

    }

    public function getBuildDirectory()
    {

    }

    public function getBuildNumber()
    {

    }

    /**
     *
     */
    abstract function runJob();

    /**
     *
     */
    abstract function generateReports();
}

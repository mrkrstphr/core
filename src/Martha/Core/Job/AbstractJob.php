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
     * @var \Martha\Core\Job\Trigger\TriggerAbstract
     */
    protected $trigger;

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

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
     * @var \Martha\Core\Job\Trigger\TriggerAbstract
     */
    protected $trigger;

    /**
     * @var \Martha\Core\Job\AbstractJob
     */
    protected $job;

    /**
     * @param AbstractJob $job
     * @param TriggerAbstract $trigger
     */
    public function __construct(AbstractJob $job, TriggerAbstract $trigger)
    {
        $this->job = $job;
        $this->trigger = $trigger;
    }

    /**
     * @return \Martha\Core\Job\Trigger\TriggerAbstract
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     *
     */
    public function run()
    {
        $this->job->run($this);
    }
}

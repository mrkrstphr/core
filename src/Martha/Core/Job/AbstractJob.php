<?php

namespace Martha\Core\Job;

use Martha\Core\Job\Task\AbstractTask;
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
     * @var array
     */
    protected $triggers = array();

    /**
     * @var array
     */
    protected $tasks = array();

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
    public function addTrigger(TriggerAbstract $trigger)
    {
        $this->triggers[] = $trigger;
        return $this;
    }

    /**
     * @return array
     */
    public function getTriggers()
    {
        return $this->triggers;
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
     * @param array $tasks
     * @return $this;
     */
    public function setTasks(array $tasks)
    {
        $this->tasks = $tasks;
        return $this;
    }

    /**
     * @param AbstractTask $task
     * @return $this
     */
    public function addTask(AbstractTask $task)
    {
        $this->tasks[] = $task;
        return $this;
    }

    /**
     * @return array
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     *
     */
    abstract function runJob(Build $build);

    /**
     *
     */
    abstract function generateReports();
}

<?php

namespace Martha\Core\Job;

use Martha\Core\Build\Build;
use Martha\Core\Job\Task\AbstractTask;
use Martha\Core\Job\Trigger\TriggerAbstract;

/**
 * Class AbstractJob
 * @package Martha\Core\Job
 */
abstract class AbstractJob
{
    /**
     * A short name for this Job which will allow it to be easily identified.
     * @var string
     */
    protected $name;

    /**
     * A verbose, optional description of this Job which provides more details about it.
     * @var string
     */
    protected $description;

    /**
     * Stores whether the Job is currently enabled and can be built.
     * @var boolean
     */
    protected $enabled = false;

    /**
     * Stores the list of known triggers for this Job.
     * @var array
     */
    protected $triggers = array();

    /**
     * @var array
     */
    protected $tasks = array();

    /**
     * Retrieves the name of the Job.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Retrieves the description of the Job.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns whether or not the build is currently enabled (ie: whether or not it can be run).
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled === true;
    }

    /**
     * Add a defined trigger for this job. A trigger is what causes the build of a job, which can be done in any
     * number of ways.
     *
     * @param TriggerAbstract $trigger
     * @return $this
     */
    public function addTrigger(TriggerAbstract $trigger)
    {
        $this->triggers[] = $trigger;
        return $this;
    }

    /**
     * Retrieves the list of defined triggers for this job.
     *
     * @return array
     */
    public function getTriggers()
    {
        return $this->triggers;
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
     * Prepares the Build to be run. This functionality is defined by the Job itself, but the implementation of this
     * method is not required in the child class.
     *
     * @param Build $build
     */
    public function prepare(Build $build)
    {
        // implementation intentionally left blank
    }

    /**
     * Runs the Build against this Job. This functionality is defined by the Job itself, and the implementation of this
     * method is required in the child class.
     *
     * @param Build $build
     * @return boolean
     */
    abstract public function run(Build $build);

    /**
     * Cleans up after a Build has been run. This functionality is defined by the Job itself, but the implementation
     * of this method is not required in the child class.
     *
     * @param Build $build
     */
    public function cleanup(Build $build)
    {
        // implementation intentionally left blank
    }
}

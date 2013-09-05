<?php

namespace Martha\Core\Job\Trigger;

/**
 * Class GitHubWebHook
 * @package Martha\Core\Job\Trigger
 */
class GitHubWebHook extends TriggerAbstract
{
    /**
     * @var array
     */
    protected $hook;

    /**
     * @param array $hook
     * @return $this
     */
    public function setHook(array $hook)
    {
        $this->hook = $hook;
        return $this;
    }

    /**
     * @return array
     */
    public function getHook()
    {
        return $this->hook;
    }

    /**
     * @return string
     */
    public function getFullProjectName()
    {
        return $this->hook['repository']['owner']['name'] . '/' . $this->hook['repository']['name'];
    }
}

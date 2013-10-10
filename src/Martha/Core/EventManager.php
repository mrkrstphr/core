<?php

namespace Martha\Core;

/**
 * Class EventManager
 * @package Martha\Core
 */
class EventManager
{
    /**
     * @var array
     */
    protected $listeners = [];

    /**
     * @param string $event
     * @param callable $callback
     */
    public function registerListener($event, callable $callback)
    {
        $event = trim(strtolower($event));

        if (!isset($this->listeners[$event])) {
            $this->listeners[$event] = [];
        }

        $this->listeners[$event][] = $callback;
    }

    /**
     * @param $event
     */
    public function trigger($event)
    {
        $event = trim(strtolower($event));

        if (isset($this->listeners[$event])) {
            foreach ($this->listeners[$event] as $callback) {
                $arguments = func_get_args();
                array_shift($arguments);
                array_unshift($arguments, $event);

                call_user_func_array($callback, $arguments);
            }
        }
    }
}

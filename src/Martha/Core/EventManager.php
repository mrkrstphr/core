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
                call_user_func_array(
                    $callback,
                    $event,
                    count(func_get_args()) > 1 ? array_shift(func_get_args()) : []
                );
            }
        }
    }
}

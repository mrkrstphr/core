<?php

namespace Martha\Core\Persistence;

use Doctrine\Common\EventManager;

/**
 * Class ConfigurationFactory
 * @package Martha\Core\Persistence
 */
class ConfigurationFactory
{
    /**
     * @var array
     */
    protected $dbParams = [];

    /**
     * @var array
     */
    protected $mappings = [];

    /**
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @param array $config
     */
    public function loadConfiguration(array $config)
    {
        if (isset($config['params']) && is_array($config['params'])) {
            $this->dbParams = $config['params'];
        }

        if (isset($config['mappings']) && is_array($config['mappings'])) {
            $this->mappings = $config['mappings'];
        }
    }

    /**
     * @param EventManager $eventManager
     * @return $this
     */
    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
        return $this;
    }

    /**
     * @return EventManager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * @return array
     */
    public function getDbParams()
    {
        return $this->dbParams;
    }

    /**
     * @return array
     */
    public function getMappingPaths()
    {
        return $this->mappings;
    }
}

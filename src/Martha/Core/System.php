<?php

namespace Martha\Core;

use Martha\Core\Plugin\PluginManager;

/**
 * Class System
 * @package Martha\Core
 */
class System
{
    /**
     * @var \Martha\Core\System
     */
    protected static $instance;

    /**
     * @var Plugin\PluginManager
     */
    protected $pluginManager;

    /**
     * @param array $config
     */
    protected function __construct(array $config)
    {
        $this->pluginManager = new PluginManager();

        $modules = glob($config['plugin-path'] . '/*');

        foreach ($modules as $module) {
            if (file_exists($module . '/Plugin.php')) {
                require_once $module . '/Plugin.php';

                $className = 'Martha\Plugin\\' . basename($module) . '\Plugin';

                if (class_exists($className)) {
                    $plugin = new $className($this->pluginManager);
                    $this->pluginManager->registerPlugin($className, $plugin);
                }
            }
        }
    }

    /**
     * @return PluginManager
     */
    public function getPluginManager()
    {
        return $this->pluginManager;
    }

    public static function initialize(array $config)
    {
        self::$instance = new self($config);
    }

    /**
     * @param array $config
     * @return System
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            throw new \Exception('Martha System was not initialized');
        }
        return self::$instance;
    }
}

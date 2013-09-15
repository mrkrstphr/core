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
        $this->loadPlugins($config);
    }

    /**
     * @param array $config
     */
    protected function loadPlugins(array $config)
    {
        // todo fixme: this makes testing very hard
        $this->pluginManager = new PluginManager();

        $path = $config['plugin-path'];

        $files = [];

        if (is_array($path)) {
            foreach ($path as $dir) {
                $files = array_merge($files, glob($dir . 'Plugin.php'));
            }
        } else {
            $files = glob($path . 'Plugin.php');
        }

        foreach ($files as $file) {
            require_once $file;

            $pluginName = basename(dirname($file));

            $className = 'Martha\Plugin\\' . $pluginName . '\Plugin';

            if (class_exists($className)) {
                $plugin = new $className(
                    $this->pluginManager,
                    isset($config['plugins'][$pluginName]) ? $config['plugins'][$pluginName] : []
                );
                $this->pluginManager->registerPlugin($className, $plugin);
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

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
     * @var array
     */
    protected $config;

    /**
     * @var Plugin\PluginManager
     */
    protected $pluginManager;

    /**
     * Set us up the Martha!
     *
     * @param array $config
     */
    protected function __construct(array $config)
    {
        $this->config = $config;
        $this->loadPlugins($config);
    }

    /**
     * Load all of the plugins.
     *
     * @param array $config
     */
    protected function loadPlugins(array $config)
    {
        // todo fixme: this makes testing very hard
        $this->pluginManager = new PluginManager($this);

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
     * Get the PluginManager.
     *
     * @return PluginManager
     */
    public function getPluginManager()
    {
        return $this->pluginManager;
    }

    /**
     * Get the URL for this Martha installation.
     *
     * @return string
     */
    public function getSiteUrl()
    {
        return isset($this->config['site_url']) ? $this->config['site_url'] : '';
    }

    /**
     * Bootstrap the Martha core system.
     *
     * @param array $config
     */
    public static function initialize(array $config)
    {
        self::$instance = new self($config);
    }

    /**
     * Get an instance of the Martha core system.
     *
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

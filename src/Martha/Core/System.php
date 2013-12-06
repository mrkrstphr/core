<?php

namespace Martha\Core;

use Doctrine\ORM\EntityManager;
use Martha\Core\Persistence\Repository\Factory;
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
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @var Factory
     */
    protected $repositoryFactory;

    /**
     * Set us up the Martha!
     *
     * @param EntityManager $em
     * @param array $config
     */
    protected function __construct(EntityManager $em, array $config)
    {
        // todo fix me, inject this instead of EntityManager
        $this->repositoryFactory = new Factory($em);
        $this->eventManager = new EventManager();

        // todo fixme: this makes testing very hard
        $this->pluginManager = new PluginManager($this);

        $this->config = $config;
        $this->loadPlugins($config);
    }

    /**
     * Load all of the plugins.
     *
     * @todo clean this up. remove the reliance on plugin-path.
     * @param array $config
     */
    protected function loadPlugins(array $config)
    {
        $path = $config['plugin-path'];
        $plugins = isset($config['plugins']) ? $config['plugins'] : [];

        if (!$plugins) {
            return;
        }

        $files = [];

        if (is_array($path)) {
            foreach ($path as $dir) {
                $files = array_merge($files, glob($dir . 'Plugin.php'));
            }
        } else {
            $files = glob($path . 'Plugin.php');
        }

        foreach ($files as $file) {
            $pluginName = basename(dirname($file));

            if (!array_key_exists($pluginName, $plugins)) {
                continue;
            }

            require_once $file;

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
     * @return EventManager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * @return Factory
     */
    public function getRepositoryFactory()
    {
        return $this->repositoryFactory;
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
     * @param EntityManager $em
     * @param array $config
     * @return $this
     */
    public static function initialize(EntityManager $em, array $config)
    {
        self::$instance = new self($em, $config);
        return self::$instance;
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
